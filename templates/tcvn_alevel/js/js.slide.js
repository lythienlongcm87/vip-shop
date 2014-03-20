;(function(jQuery) {

    jQuery.fn.manufacturerSlide = function(arg) {

        var options = jQuery.extend({}, jQuery.fn.manufacturerSlide.defaults, arg);

        return this.each(function() {

            // Define The Container
            var container = jQuery(this);

            // Build The Prev & Next Buttons & Define Them
            buildPrevNextButtons();
            var height = {
                top: (options.height / 2) - (options.buttonHeight / 2)
            };
            var nextButton = container.find('span.next-item').css(height);
            var prevButton = container.find('span.prev-item').css(height);

            // Define UI Container
            var uiContainer = container.find('ul');

            // Define List Elements Within The UI Container
            var uiListElements = uiContainer.find('li').hide();
            var uiListElementsLength = uiListElements.length - 1;
            var firstVisibleElement = options.numberListElements - options.numberListElements;
            var lastVisibleElement = options.numberListElements - 1;

            listElementWidth(lastVisibleElement);

            function listElementWidth(lastVisibleElement) {
                if(options.numberListElements == 3) {
                    uiListElements.removeClass('span34');
                    uiListElements.addClass('span33');
                    uiContainer.find('li:nth-child(3n-2)').addClass('span34').removeClass('span33');
                }
            }

            // Lets Show The Defined Number Of List Elements
            uiContainer.find('li:lt(' + options.numberListElements + ')').show();

            nextButton.on('click', function () {
                buildSlider('next');
            });

            prevButton.on('click', function () {
                buildSlider('prev');
            });

            function buildSlider(direction) {
                if(direction == 'next') {
                    var nextListElement = uiListElements.eq(lastVisibleElement).next('li');
                    if(nextListElement.html()) {
                        animation(direction,nextListElement);
                        firstVisibleElement = firstVisibleElement + 1;
                        lastVisibleElement = lastVisibleElement + 1;
                        uiListElements = uiContainer.find('li');
                        listElementWidth(lastVisibleElement);
                    } else {
                        var nextListElement = uiListElements.first('li').appendTo(uiContainer);
                        animation(direction,nextListElement);
                        uiListElements = uiContainer.find('li');
                        listElementWidth(lastVisibleElement);
                    }
                }

                if(direction == 'prev') {

                    var nextListElement = uiListElements.eq(firstVisibleElement).prev('li');
                    if(nextListElement.html()) {
                        animation(direction,nextListElement);
                        firstVisibleElement = firstVisibleElement - 1;
                        lastVisibleElement = lastVisibleElement - 1;
                        uiListElements = uiContainer.find('li');
                        listElementWidth(lastVisibleElement);
                    } else {
                        console.log('bin ich aktiv?');
                        var nextListElement = uiListElements.last('li').prependTo(uiContainer);
                        animation(direction,nextListElement);
                        uiListElements = uiContainer.find('li');
                        listElementWidth(lastVisibleElement);
                    }
                }
            }

            function animation(direction,nextListElement) {

                if(direction == 'next') {
                    uiListElements.eq(firstVisibleElement)
                        .animate({

                        },200, function() {
                            jQuery(this).css({

                                float: 'left'
                            }).hide();
                            nextListElement.fadeIn(200);
                        });
                }

                if(direction == 'prev') {
                    uiListElements.eq(lastVisibleElement).css({

                    }).fadeOut(200, function() {
                            nextListElement.css({

                                float: 'left'
                            }).show().animate({

                                },200);
                        });
                }
            }

            function buildPrevNextButtons() {
                container.prepend('<span class="next-item"><span>next</span></span>');
                container.prepend('<span class="prev-item"><span>prev</span></span>');
            }

            // Should We Run A Slideshow
            if (options.autoPlay) {

                // Definition Of Slideshow
                // What Should It DO
                var startSlideshow = setInterval(function() {

                    buildSlider('next');

                }, options.interval);
            }

        });
    };

    // Definition Of Defaults
    jQuery.fn.manufacturerSlide.defaults = {
        numberListElements: 3,
        autoPlay: false,
        interval: 3000,
        height: 160,
        buttonHeight: 28
    };
})(jQuery);
