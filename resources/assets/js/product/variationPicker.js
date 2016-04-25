var typePicker = function (variations) {
    return {

        variations: null,

        selectedVariationId: 0,

        selectedType: '',

        html: '',

        init: function (variations) {
            this.variations = variations;
            return this;
        },

        /**
         * Construct the type picker
         */
        construct: function () {
            var _this = this;
            var html = '<ul class="type-picker js-type-picker">';
            var variationTypes = [];
            $.each(_this.variations, function (index, variation) {
                if (variationTypes.indexOf(variation.type) == -1) variationTypes.push(variation.type);
            });
            $.each(variationTypes, function (index, type) {
                html += _this.typeTemplate(type);
            });
            html += '</ul>';
            _this.html = html;
            return _this;
        },

        /**
         * One type option
         * @param type
         */
        typeTemplate: function (type) {
            return '<li class="type-option js-type-option"><a href="#" data-type="' + type + '">' +
                '<span>' + type + '</span>' +
                '</a></li>';
        },

        /**
         * To set a given type as active
         * @param type
         */
        activateType: function (type) {
            this.selectedType = type;
            $('.js-type-option').removeClass('active').removeClass('unavailable').each(function () {
                if ($(this).find('a').data('type') == type) $(this).addClass('active');
            });
        },

        /**
         * Mark the unavailable items as such
         * @param type
         */
        deactivate: function (type) {
            $('.js-type-option').each(function () {
                if (type == $(this).find('a').data('type')) $(this).addClass('unavailable');
            });
        },

        /**
         * Render the picker to a container
         * @param $container
         * @param callback
         */
        render: function ($container, callback) {
            $container.append(this.html);
            $('.js-type-option a').on('click', function (e) {
                e.preventDefault();
                callback($(this).data('type'));
            });
            return this;
        }

    }.init(variations);
};

var sizePicker = function (variations) {
    return {

        variations: null,

        selectedSize: '',

        html: '',

        init: function (variations) {
            this.variations = variations;
            return this;
        },

        /**
         * Construct the size picker
         */
        construct: function () {
            var _this = this;
            var html = '<ul class="size-picker js-size-picker">';
            var variationTypes = [];
            $.each(_this.variations, function (index, variation) {
                if (variationTypes.indexOf(variation.size) == -1) variationTypes.push(variation.size);
            });
            $.each(variationTypes, function (index, size) {
                html += _this.sizeTemplate(size);
            });
            html += '</ul>';
            _this.html = html;
            return _this;
        },

        /**
         * One size option
         * @param size
         */
        sizeTemplate: function (size) {
            return '<li class="size-option js-size-option"><a href="#" data-size="' + size + '">' +
                '<span>' + size + '</span>' +
                '</a></li>';
        },

        /**
         * To set a given size as active
         * @param size
         */
        activateSize: function (size) {
            this.selectedSize = size;
            $('.js-size-option').removeClass('active').removeClass('unavailable').each(function () {
                if ($(this).find('a').data('size') == size) $(this).addClass('active');
            });
        },

        /**
         * Mark the unavailable items as such
         * @param size
         */
        deactivate: function (size) {
            $('.js-size-option').each(function () {
                if (size == $(this).find('a').data('size')) $(this).addClass('unavailable');
            });
        },

        /**
         * Render the picker to a container
         * @param $container
         * @param callback
         */
        render: function ($container, callback) {
            $container.append(this.html);
            $('.js-size-option a').on('click', function (e) {
                e.preventDefault();
                callback($(this).data('size'));
            });
            return this;
        }

    }.init(variations);
};

var colorPicker = function (variations) {
    return {

        variations: null,

        selectedColor: '',

        html: '',

        init: function (variations) {
            this.variations = variations;
            return this;
        },

        /**
         * Construct the color picker
         */
        construct: function () {
            var _this = this;
            var html = '<ul class="color-picker js-color-picker">';
            var variationColors = [];
            $.each(_this.variations, function (index, variation) {
                if (variationColors.map(function (element) {
                        return element.color;
                    }).indexOf(variation.color) == -1) {
                    variationColors.push({
                        color: variation.color,
                        hex: variation.colorHex
                    });
                }
            });
            $.each(variationColors, function (index, color) {
                html += _this.colorTemplate(color);
            });
            html += '</ul>';
            _this.html = html;
            return _this;
        },

        /**
         * One color option
         * @param color
         */
        colorTemplate: function (color) {
            return '<li class="color-option js-color-option">' +
                '<a href="#" data-color="' + color.color + '" style="background-color: ' + color.hex + ';">' +
                '</a></li>';
        },

        /**
         * To set a given color as active
         * @param color
         */
        activateColor: function (color) {
            this.selectedColor = color;
            $('.js-color-option').removeClass('active').removeClass('unavailable').each(function () {
                if ($(this).find('a').data('color') == color) $(this).addClass('active');
            });
        },

        /**
         * Mark the unavailable items as such
         * @param color
         */
        deactivate: function (color) {
            $('.js-color-option').each(function () {
                if (color == $(this).find('a').data('color')) $(this).addClass('unavailable');
            });
        },

        /**
         * Render the picker to a container
         * @param $container
         * @param callback
         */
        render: function ($container, callback) {
            $container.append(this.html);
            $('.js-color-option a').on('click', function (e) {
                e.preventDefault();
                callback($(this).data('color'));
            });
            return this;
        }

    }.init(variations);
};

var variationPicker = function ($container) {
    return {

        /**
         * jQuery container object
         */
        $container: null,

        /**
         * Currently selected variation ID
         */
        selectedVariationId: null,

        /**
         * @property variations
         */
        product: null,

        /**
         * HTML to show while picker is loading
         */
        loadingSpinner: '<i class="fa fa-spinner fa-spin"></i>',

        /**
         * typePicker Object
         */
        typePicker: null,

        /**
         * sizePicker Object
         */
        sizePicker: null,

        /**
         * colorPicker Object
         */
        colorPicker: null,

        /**
         * @param $container jQuery object
         */
        init: function ($container) {
            this.$container = $container.html(this.loadingSpinner);
            this.selectedVariationId = $('#productVariationId').val();
            this.loadProduct();
        },

        /**
         * Load the product details and all variations
         */
        loadProduct: function () {
            var _this = this;
            apiManager.makeCall('product', 'find', {productId: $('#productId').val()}, function (response) {
                console.log(response.data);
                _this.product = response.data;
                _this.buildVariationPicker();
            });
        },

        /**
         * Construct the picker based on available variations
         */
        buildVariationPicker: function () {
            var _this = this;
            _this.$container.html('');
            _this.typePicker = typePicker(_this.product.variations).construct().render(_this.$container, function (type) {
                _this.getVariationMatch(type, _this.sizePicker.selectedSize, _this.colorPicker.selectedColor, 'type')
            });
            _this.sizePicker = sizePicker(_this.product.variations).construct().render(_this.$container, function (size) {
                _this.getVariationMatch(_this.typePicker.selectedType, size, _this.colorPicker.selectedColor, 'size');
            });
            _this.colorPicker = colorPicker(_this.product.variations).construct().render(_this.$container, function (color) {
                _this.getVariationMatch(_this.typePicker.selectedType, _this.sizePicker.selectedSize, color, 'color');
            });

            // select the initial variation based on form
            var initialFound = false;
            $.each(_this.product.variations, function(index, variation) {
                if (variation.id == $('#productVariationId').val()) {
                    initialFound = true;
                    _this.variationBuild(variation);
                }
            });

            if (!initialFound) _this.variationBuild(_this.product.variations[0]);
        },

        /**
         * Find the matching variation for the selected options. If no full match found,
         *      get best match for the fixed field
         * @param type
         * @param size
         * @param color
         * @param fixed str | type, color or size
         */
        getVariationMatch: function (type, size, color, fixed) {
            var _this = this;
            var found = false;
            $.each(_this.product.variations, function (index, variation) {
                if ((variation.type == type || type === null) && (variation.size == size || size === null) && (variation.color == color || color === null)) {
                    found = true;
                    _this.variationBuild(variation);
                }
            });
            if (!found) {
                if (fixed === 'type') _this.getVariationMatch(type, size, null, 'type2');
                if (fixed === 'size') _this.getVariationMatch(null, size, color, 'size2');
                if (fixed === 'color') _this.getVariationMatch(type, null, color, 'color2');
                if (fixed === 'type2') _this.getVariationMatch(type, null, null, null);
                if (fixed === 'size2') _this.getVariationMatch(null, size, null, null);
                if (fixed === 'color2') _this.getVariationMatch(null, null, color, null);
                if (fixed === null) {
                    _this.variationBuild(_this.product.variations[0]);
                }
            }
        },

        /**
         * Make all the on-page updates required when the selected
         *    variation has changed
         * @param variation
         */
        variationBuild: function (variation) {
            var _this = this;
            _this.selectedVariationId = variation.id;
            $('#productVariationId').val(variation.id);
            $('.js-product-price').html(variation.price);

            _this.colorPicker.activateColor(variation.color);
            _this.typePicker.activateType(variation.type);
            _this.sizePicker.activateSize(variation.size);

            _this.markUnavailable();
        },

        /**
         * Go through each setting and mark the unavailable combinations
         */
        markUnavailable: function() {
            this.typesMarkUnavailable();
            this.colorsMarkUnavailable();
            this.sizesMarkUnavailable();
        },

        /**
         * Mark unavailable variation properties for type
         *    based on the other two remaining fixed
         */
        typesMarkUnavailable: function () {
            var _this = this;
            var typesToRemove = [];
            $.each(_this.product.variations, function (index, variation) {
                if (typesToRemove.indexOf(variation.type) == -1) typesToRemove.push(variation.type);
            });

            $.each(_this.product.variations, function (index, variation) {
                if (variation.color == _this.colorPicker.selectedColor &&
                    variation.size == _this.sizePicker.selectedSize
                ) {
                    // it's a match, remove from typesToRemove if it's there
                    var newArray = [];
                    $.each(typesToRemove, function(index, val) {
                        if (val !== variation.type) newArray.push(val);
                    });
                    typesToRemove = newArray;
                }
            });

            $.each(typesToRemove, function(index, val) {
                _this.typePicker.deactivate(val);
            });
        },

        /**
         * Mark unavailable variation properties for color
         *    based on the other two remaining fixed
         */
        colorsMarkUnavailable: function () {
            var _this = this;
            var colorsToRemove = [];
            $.each(_this.product.variations, function (index, variation) {
                if (colorsToRemove.indexOf(variation.color) == -1) colorsToRemove.push(variation.color);
            });

            $.each(_this.product.variations, function (index, variation) {
                if (variation.type == _this.typePicker.selectedType &&
                    variation.size == _this.sizePicker.selectedSize
                ) {
                    // it's a match, remove from colorsToRemove if it's there
                    var newArray = [];
                    $.each(colorsToRemove, function(index, val) {
                        if (val !== variation.color) newArray.push(val);
                    });
                    colorsToRemove = newArray;
                }
            });

            $.each(colorsToRemove, function(index, val) {
                _this.colorPicker.deactivate(val);
            });
        },

        /**
         * Mark unavailable variation properties for size
         *    based on the other two remaining fixed
         */
        sizesMarkUnavailable: function () {
            var _this = this;
            var sizesToRemove = [];
            $.each(_this.product.variations, function (index, variation) {
                if (sizesToRemove.indexOf(variation.size) == -1) sizesToRemove.push(variation.size);
            });

            $.each(_this.product.variations, function (index, variation) {
                if (variation.color == _this.colorPicker.selectedColor &&
                    variation.type == _this.typePicker.selectedType
                ) {
                    // it's a match, remove from sizesToRemove if it's there
                    var newArray = [];
                    $.each(sizesToRemove, function(index, val) {
                        if (val !== variation.size) newArray.push(val);
                    });
                    sizesToRemove = newArray;
                }
            });

            $.each(sizesToRemove, function(index, val) {
                _this.sizePicker.deactivate(val);
            });
        },

    }.init($container)
};