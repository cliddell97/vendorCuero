<?php

namespace Webimpress\SafeWriter;

use function chmod;
use function dirname;
use function file_put_contents;
use function is_writable;
use function realpath;
use function rename;
use function stripos;
use function tempnam;
use function umask;
use function unlink;

use const PHP_OS;

final class FileWriter
{
    /**
     * @param string $file
     * @param string $content
     * @param int $chmod
     * @return void
     * @throws Exception\ExceptionInterface
     */
    public static function writeFile($file, $content, $chmod = 0666)
    {
        $dir = dirname($file);
        // suppress notice thrown when falling back to system temp dir
        $tmp = @tempnam($dir, 'wsw');

        if ($tmp === false) {
            throw Exception\RuntimeException::unableToCreateTemporaryFile($dir);
        }

        if (dirname($tmp) !== realpath($dir)) {
            unlink($tmp);
            throw Exception\RuntimeException::unableToCreateTemporaryFile($dir);
        }

        if (file_put_contents($tmp, $content) === false) {
            unlink($tmp);
            throw Exception\WriteContentException::unableToWriteContent($tmp);
        }

        if (chmod($tmp, $chmod & ~umask()) === false) {
            unlink($tmp);
            throw Exception\ChmodException::unableToChangeChmod($tmp);
        }

        // On windows try again if rename was not successful but target file is writable.
        while (@rename($tmp, $file) === false) {
            if (is_writable($file) && stripos(PHP_OS, 'WIN') === 0) {
                continue;
            }

            unlink($tmp);
            throw Exception\RenameException::unableToMoveFile($tmp, $file);
        }
    }
}
