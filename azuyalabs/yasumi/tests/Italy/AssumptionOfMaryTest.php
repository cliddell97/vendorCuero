<?php
/**
 * This file is part of the Yasumi package.
 *
 * Copyright (c) 2015 - 2019 AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

namespace Yasumi\tests\Italy;

use DateTime;
use Yasumi\Holiday;
use Yasumi\tests\YasumiTestCaseInterface;

/**
 * Class for testing the day of the Assumption of Mary in Italy.
 */
class AssumptionOfMaryTest extends ItalyBaseTestCase implements YasumiTestCaseInterface
{
    /**
     * The name of the holiday
     */
    const HOLIDAY = 'assumptionOfMary';

    /**
     * Tests the day of the Assumption of Mary.
     *
     * @dataProvider AssumptionOfMaryDataProvider
     *
     * @param int      $year     the year for which the day of the Assumption of Mary needs to be tested
     * @param DateTime $expected the expected date
     */
    public function testAssumptionOfMary($year, $expected)
    {
        $this->assertHoliday(self::REGION, self::HOLIDAY, $year, $expected);
    }

    /**
     * Returns a list of random test dates used for assertion of the day of the Assumption of Mary.
     *
     * @return array list of test dates for the day of the Assumption of Mary
     */
    public function AssumptionOfMaryDataProvider()
    {
        return $this->generateRandomDates(8, 15, self::TIMEZONE);
    }

    /**
     * Tests translated name of the Assumption of Mary.
     */
    public function testTranslation()
    {
        $this->assertTranslatedHolidayName(
            self::REGION,
            self::HOLIDAY,
            $this->generateRandomYear(),
            [self::LOCALE => 'Assunzione di Maria Vergine']
        );
    }

    /**
     * Tests type of the holiday defined in this test.
     */
    public function testHolidayType()
    {
        $this->assertHolidayType(self::REGION, self::HOLIDAY, $this->generateRandomYear(), Holiday::TYPE_OFFICIAL);
    }
}
