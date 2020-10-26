define([
    'ko',
    'Magento_Ui/js/form/element/abstract',
    'Dhl_Shipping/js/model/service-validation-map',
    'Dhl_Shipping/js/model/services',
    'Dhl_Shipping/js/action/validate-service-compatibility',
    'Dhl_Shipping/js/action/enforce-service-compatibility',
], function (ko, Component, serviceValidationMap, serviceSelection, validateCompatibility, enforceCompatibility) {
    'use strict';

    return Component.extend({
        defaults: {
            provider: {},
            autocomplete: '',
            serviceInput: {},
            service: {},
            serviceCode: '',
            lastValue: '',
        },

        initialize: function () {
            this._super();
            this.initFieldData();

            var serviceCode = this.service.code,
                inputCode = this.serviceInput.code;
            try {
                this.value(serviceSelection.get()()[serviceCode][inputCode])
            } catch (e) {
                // no cached value found.
            }

            this.value.subscribe(function (value) {
                if (value) {
                    serviceSelection.addService(
                        this.service.code,
                        this.serviceInput.code,
                        value
                    );
                } else {
                    serviceSelection.removeService(
                        this.service.code,
                        this.serviceInput.code
                    );
                }
                enforceCompatibility();
                validateCompatibility();
            }.bind(this));
        },

        initFieldData: function () {
            var validationData = {};
            _.each(this.serviceInput.validationRules, function (value, rule) {
                var validatorName = serviceValidationMap.getValidatorName(rule);
                if (validatorName) {
                    validationData[validatorName] = value;
                } else {
                    console.warn('DHL service validation rule ' + rule + ' is not defined.');
                }
            });

            this.validation = validationData;
            this.template = 'Dhl_Shipping/checkout/form/field';
            this.elementTmpl = this.getTemplateForType(this.serviceInput.inputType);
            this.label = this.description = this.serviceInput.label;
            this.placeholder = this.serviceInput.placeholder;
            if (this.serviceInput.tooltip) {
                this.tooltip = {description: this.serviceInput.tooltip};
            }
            this.hasAsterisk = this.serviceInput.hasAsterisk;
            if (ko.isObservable(this.notice)) {
                this.notice(this.serviceInput.infoText);
            } else {
                this.notice = this.serviceInput.infoText;
            }
            this.inputName = this.serviceInput.code;
            this.autocomplete = this.serviceInput.code;
            this.serviceCode = this.service.code;
        },

        getTemplateForType: function (type) {
            var templates = {
                text: 'ui/form/element/input',
                checkbox: 'Dhl_Shipping/checkout/form/element/checkbox',
                time: 'Dhl_Shipping/checkout/form/element/radio',
                date: 'Dhl_Shipping/checkout/form/element/radio'
            };
            if (templates[type]) {
                return templates[type];
            }

            return false;
        },

        /**
         * Unselect the radio set when an already selected item is clicked.
         *
         * @returns {Boolean}
         */
        handleRadioUnselect: function () {
            if (this.lastValue === this.value()) {
                this.value('');
            }
            this.lastValue = this.value();
            return true;
        },

        onUpdate: function () {
            this._super();
        },

        /**
         * M2.1 fallback for non-existent parent method.
         *
         * @returns {String}
         */
        getDescriptionId: function () {
            if (typeof this._super === "function") {
                return this._super();
            }

            return '';
        }
    });
});
