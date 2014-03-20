
// ########### Tabfunctions ####################
(function(jQuery) {

    jQuery.fn.productPresenter = function(arg) {

        var options = jQuery.extend({}, jQuery.fn.productPresenter.defaults, arg);

        return this.each(function() {

            var container = jQuery(this);

            // Define Product Container
            var productContainer = container.find('div.product-container').hide();

            // Build The list With Category Names
            buildCategoryUIList(container,options);

            // Define Category Names Container
            var categoryNamesContainer = container.find('ul#category-names');
            var pill = categoryNamesContainer.find('span.pill');
            var pillStartPosition = pill.position();
            var categoryNames = categoryNamesContainer.find('li');
            var categoryNamesStartPosition = categoryNames.first().position();

            // Add Class 'Active' To The First Category Name And Save Index
            var activeCategoryName = categoryNamesContainer.find('li:nth-child(' + options.startIndex + ')').addClass('active');
            var activeCategoryNameIndex = activeCategoryName.index();

            // Set The Pill To The Right Position At Start
            var position = activeCategoryName.position();
            var nextPosition = activeCategoryName.next().position();
            var pillPosition = (nextPosition['left'] - position['left']) / 2 + position['left'] - (options.arrowWidth / 2);
            pill.css({
                left: pillPosition
            });

            // Show The Product Container With The Same Index As Category Name
            productContainer.eq(activeCategoryNameIndex).show();

            // Switch The Product Container
            categoryNames.on('click', function() {

                categoryNames.removeClass('active');
                var previousActiveCategoryNameIndex = activeCategoryNameIndex;

                // This Is Our Clicked Element
                var clickedName = jQuery(this).addClass('active');
                activeCategoryNameIndex = clickedName.index();

                if(previousActiveCategoryNameIndex == activeCategoryNameIndex) {
                    // We Do No Animation
                } else {
                    productContainer.hide();
                    productContainer.eq(activeCategoryNameIndex).fadeIn(500);

                    // Creation Of Pill Animation
                    if(activeCategoryNameIndex > previousActiveCategoryNameIndex) {

                        var position = clickedName.position();
                        var nextPosition = clickedName.next('li').position();

                        if (nextPosition) {
                            var nextElementPosition = nextPosition['left'];
                        } else {
                            var nextElementPosition = pillStartPosition['left'];
                        }

                        var pillPosition = (nextElementPosition - position['left']) / 2 + position['left'] - (options.arrowWidth / 2);
                        pill.animate({
                            left: pillPosition
                        });

                    } else {

                        var position = clickedName.position();
                        var nextPosition = clickedName.next('li').position();

                        if(nextPosition) {
                            var pillPosition = (nextPosition['left'] - position['left']) / 2 + position['left'] - (options.arrowWidth / 2);
                        } else {
                            var pillPosition = categoryNamesStartPosition['left'];
                        }

                        pill.animate({
                            left: pillPosition
                        });
                    }
                }


            });



            //jQuery(this).html(options.categoryNames[0]);




        });
    };

    /**
     * Build The list With Category Names
     *
     * @param container
     * @param options
     */
    function buildCategoryUIList(container, options) {

        // Create UI Element
        if(options.navigationTop) {
            container.prepend('<ul id="category-names" class="category-names-top"></ul>');
        } else {
            container.append('<ul id="category-names" class="category-names-bottom"></ul>');
        }

        var uiContainer = container.find('ul#category-names');

        // Create <li> Elements Within Category Name Container
        jQuery.each(options.categoryNames, function(index, value) {
            uiContainer.append('<li>' + value + '</li>');
        });

        uiContainer.append('<span class="pill"></span>');

    };

    // Definition Of Defaults
    jQuery.fn.productPresenter.defaults = {
        categoryNames: 'value1',
        navigationTop: true,
        arrowWidth: 14,
        startIndex: 1
    };

})(jQuery);