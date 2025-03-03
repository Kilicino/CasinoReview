/**
 * Main JavaScript file for the Casino Review Pro theme
 *
 * Contains all custom functionality for the theme
 */

(function($) {
    'use strict';

    // Variables
    var $body = $('body'),
        $window = $(window),
        $document = $(document),
        $siteHeader = $('.site-header'),
        $menuToggle = $('.menu-toggle'),
        $primaryMenu = $('.primary-menu'),
        $casinoFaq = $('.casino-faq'),
        $casinoToc = $('.casino-toc');

    // DOM Ready
    $(function() {
        mobileMenu();
        stickyHeader();
        faqToggle();
        smoothScroll();
        ratingStars();
        tooltips();
        compareTables();
        casinoFilters();
        readMore();
        bonusSlider();
        gamesCarousel();
    });

    /**
     * Mobile Menu functionality
     */
    function mobileMenu() {
        $menuToggle.on('click', function() {
            $body.toggleClass('menu-open');
            $primaryMenu.slideToggle();
            
            if ($body.hasClass('menu-open')) {
                $(this).attr('aria-expanded', 'true');
            } else {
                $(this).attr('aria-expanded', 'false');
            }
        });

        // Add dropdown toggle to menu items with children
        $('.menu-item-has-children > a').after('<span class="dropdown-toggle"><i class="fa-solid fa-chevron-down"></i></span>');

        // Toggle submenu on dropdown toggle click
        $('.dropdown-toggle').on('click', function(e) {
            e.preventDefault();
            $(this).toggleClass('toggled');
            $(this).next('.sub-menu').slideToggle();
        });

        // Reset menu on window resize
        $window.on('resize', function() {
            if ($window.width() > 768) {
                $primaryMenu.removeAttr('style');
                $('.sub-menu').removeAttr('style');
                $('.dropdown-toggle').removeClass('toggled');
                $body.removeClass('menu-open');
                $menuToggle.attr('aria-expanded', 'false');
            }
        });
    }

    /**
     * Sticky header functionality
     */
    function stickyHeader() {
        var headerHeight = $siteHeader.outerHeight(),
            scrollTop = 0,
            scrolled = false;

        $window.on('scroll', function() {
            scrollTop = $window.scrollTop();

            if (scrollTop > headerHeight && !scrolled) {
                $body.addClass('sticky-header');
                $siteHeader.addClass('sticky');
                scrolled = true;
            } else if (scrollTop <= headerHeight && scrolled) {
                $body.removeClass('sticky-header');
                $siteHeader.removeClass('sticky');
                scrolled = false;
            }
        });
    }

    /**
     * FAQ toggle functionality
     */
    function faqToggle() {
        if ($casinoFaq.length) {
            // Add toggle buttons
            $('.faq-question').append('<span class="faq-toggle"><i class="fa-solid fa-plus"></i></span>');

            // Hide all answers initially
            $('.faq-answer').hide();

            // Toggle FAQ answer on question click
            $('.faq-question').on('click', function() {
                var $this = $(this),
                    $answer = $this.next('.faq-answer'),
                    $toggle = $this.find('.faq-toggle'),
                    $icon = $toggle.find('i');

                $answer.slideToggle(300);
                
                if ($icon.hasClass('fa-plus')) {
                    $icon.removeClass('fa-plus').addClass('fa-minus');
                } else {
                    $icon.removeClass('fa-minus').addClass('fa-plus');
                }
            });
        }
    }

    /**
     * Smooth scroll functionality
     */
    function smoothScroll() {
        // Smooth scroll to anchor links
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.hash);
            
            if (target.length) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 800);
            }
        });

        // Table of contents
        if ($casinoToc.length) {
            // Highlight active TOC item on scroll
            $window.on('scroll', function() {
                var scrollPos = $window.scrollTop();
                
                $('.casino-section').each(function() {
                    var sectionPos = $(this).offset().top - 120,
                        sectionId = $(this).attr('id');
                    
                    if (scrollPos >= sectionPos) {
                        $casinoToc.find('a').removeClass('active');
                        $casinoToc.find('a[href="#' + sectionId + '"]').addClass('active');
                    }
                });
            });
        }
    }

    /**
     * Rating stars functionality
     */
    function ratingStars() {
        // Interactive star ratings for comments
        $('.comment-rating-stars').each(function() {
            var $this = $(this),
                $stars = $this.find('.star'),
                $input = $this.siblings('input[type="hidden"]');

            $stars.on('mouseover', function() {
                var index = $(this).index();
                
                $stars.each(function(i) {
                    if (i <= index) {
                        $(this).addClass('hover');
                    } else {
                        $(this).removeClass('hover');
                    }
                });
            });

            $stars.on('mouseout', function() {
                $stars.removeClass('hover');
            });

            $stars.on('click', function() {
                var index = $(this).index();
                
                $stars.removeClass('selected');
                
                $stars.each(function(i) {
                    if (i <= index) {
                        $(this).addClass('selected');
                    }
                });
                
                $input.val(index + 1);
            });
        });
    }

    /**
     * Tooltips functionality
     */
    function tooltips() {
        // Initialize tooltips
        $('.tooltip').each(function() {
            var $this = $(this),
                tooltipText = $this.data('tooltip');
            
            $this.append('<span class="tooltip-content">' + tooltipText + '</span>');
        });

        // Position tooltips on hover
        $('.tooltip').on('mouseenter', function() {
            var $tooltip = $(this).find('.tooltip-content'),
                tooltipWidth = $tooltip.outerWidth(),
                tooltipHeight = $tooltip.outerHeight(),
                elementWidth = $(this).outerWidth(),
                windowWidth = $window.width(),
                offset = $(this).offset().left,
                rightSpace = windowWidth - offset - elementWidth;
            
            if (tooltipWidth > rightSpace) {
                $tooltip.addClass('tooltip-left');
            } else {
                $tooltip.removeClass('tooltip-left');
            }
        });
    }

    /**
     * Comparison tables functionality
     */
    function compareTables() {
        // Highlight row on hover
        $('.comparison-table tr').on('mouseenter', function() {
            $(this).addClass('hover');
        }).on('mouseleave', function() {
            $(this).removeClass('hover');
        });

        // Sortable tables
        $('.sortable-table th').on('click', function() {
            var $table = $(this).parents('table'),
                index = $(this).index(),
                $rows = $table.find('tbody tr').toArray(),
                isNumeric = $(this).hasClass('numeric'),
                direction = $(this).hasClass('asc') ? -1 : 1;
            
            // Update sort direction
            $table.find('th').removeClass('asc desc');
            
            if (direction === 1) {
                $(this).addClass('asc');
            } else {
                $(this).addClass('desc');
            }
            
            // Sort rows
            $rows.sort(function(a, b) {
                var keyA = $(a).children('td').eq(index).text(),
                    keyB = $(b).children('td').eq(index).text();
                
                if (isNumeric) {
                    keyA = parseFloat(keyA);
                    keyB = parseFloat(keyB);
                    
                    return direction * (keyA - keyB);
                } else {
                    return direction * keyA.localeCompare(keyB);
                }
            });
            
            // Reorder rows
            $.each($rows, function(index, row) {
                $table.find('tbody').append(row);
            });
        });
    }

    /**
     * Casino filters functionality
     */
    function casinoFilters() {
        // Filter toggle on mobile
        $('.filter-toggle').on('click', function() {
            $('.filter-form').slideToggle();
            $(this).toggleClass('active');
        });

        // Ajax filter for casino lists
        $('.ajax-filter select, .ajax-filter input[type="radio"]').on('change', function() {
            var $form = $(this).closest('form'),
                formData = $form.serialize(),
                targetContainer = $form.data('target');
            
            $.ajax({
                url: casino_review_vars.ajaxurl,
                type: 'post',
                data: {
                    action: 'filter_casinos',
                    nonce: casino_review_vars.nonce,
                    data: formData
                },
                beforeSend: function() {
                    $(targetContainer).addClass('loading');
                },
                success: function(response) {
                    $(targetContainer).html(response).removeClass('loading');
                }
            });
        });
    }

    /**
     * Read more functionality
     */
    function readMore() {
        $('.read-more-toggle').on('click', function(e) {
            e.preventDefault();
            
            var $this = $(this),
                $content = $this.prev('.read-more-content'),
                moreText = $this.data('more-text'),
                lessText = $this.data('less-text');
            
            if ($content.hasClass('expanded')) {
                $content.removeClass('expanded');
                $this.html(moreText);
            } else {
                $content.addClass('expanded');
                $this.html(lessText);
            }
        });
    }

    /**
     * Bonus slider functionality
     */
    function bonusSlider() {
        // Check if bonus slider exists
        if ($('.bonus-slider').length) {
            $('.bonus-slider').each(function() {
                var $slider = $(this),
                    $slides = $slider.find('.bonus-slide'),
                    $dots = $slider.find('.slider-dots'),
                    $prev = $slider.find('.slider-prev'),
                    $next = $slider.find('.slider-next'),
                    totalSlides = $slides.length,
                    currentSlide = 0;
                
                // Create dot indicators
                for (var i = 0; i < totalSlides; i++) {
                    $dots.append('<span class="dot" data-slide="' + i + '"></span>');
                }
                
                // Initialize first slide and dot
                $slides.eq(0).addClass('active');
                $dots.find('.dot').eq(0).addClass('active');
                
                // Show slide function
                function showSlide(index) {
                    $slides.removeClass('active');
                    $dots.find('.dot').removeClass('active');
                    
                    $slides.eq(index).addClass('active');
                    $dots.find('.dot').eq(index).addClass('active');
                    
                    currentSlide = index;
                }
                
                // Next slide
                $next.on('click', function() {
                    var nextSlide = (currentSlide + 1) % totalSlides;
                    showSlide(nextSlide);
                });
                
                // Previous slide
                $prev.on('click', function() {
                    var prevSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                    showSlide(prevSlide);
                });
                
                // Dot navigation
                $dots.on('click', '.dot', function() {
                    var slideIndex = $(this).data('slide');
                    showSlide(slideIndex);
                });
                
                // Auto rotate slides
                var slideInterval = setInterval(function() {
                    var nextSlide = (currentSlide + 1) % totalSlides;
                    showSlide(nextSlide);
                }, 5000);
                
                // Pause on hover
                $slider.on('mouseenter', function() {
                    clearInterval(slideInterval);
                }).on('mouseleave', function() {
                    slideInterval = setInterval(function() {
                        var nextSlide = (currentSlide + 1) % totalSlides;
                        showSlide(nextSlide);
                    }, 5000);
                });
            });
        }
    }

    /**
     * Games carousel functionality
     */
    function gamesCarousel() {
        // Check if games carousel exists
        if ($('.games-carousel').length) {
            $('.games-carousel').each(function() {
                var $carousel = $(this),
                    $items = $carousel.find('.game-item'),
                    $prev = $carousel.find('.carousel-prev'),
                    $next = $carousel.find('.carousel-next'),
                    itemWidth = $items.first().outerWidth(true),
                    visibleItems = Math.floor($carousel.width() / itemWidth),
                    maxScroll = Math.max(0, $items.length - visibleItems),
                    currentPosition = 0;
                
                // Set initial state
                updateCarouselState();
                
                // Update carousel on window resize
                $window.on('resize', function() {
                    itemWidth = $items.first().outerWidth(true);
                    visibleItems = Math.floor($carousel.width() / itemWidth);
                    maxScroll = Math.max(0, $items.length - visibleItems);
                    
                    // Reset position if needed
                    if (currentPosition > maxScroll) {
                        currentPosition = maxScroll;
                        scrollCarousel();
                    }
                    
                    updateCarouselState();
                });
                
                // Scroll to next items
                $next.on('click', function() {
                    if (currentPosition < maxScroll) {
                        currentPosition++;
                        scrollCarousel();
                        updateCarouselState();
                    }
                });
                
                // Scroll to previous items
                $prev.on('click', function() {
                    if (currentPosition > 0) {
                        currentPosition--;
                        scrollCarousel();
                        updateCarouselState();
                    }
                });
                
                // Scroll carousel function
                function scrollCarousel() {
                    var scrollAmount = -currentPosition * itemWidth;
                    $carousel.find('.carousel-items').css('transform', 'translateX(' + scrollAmount + 'px)');
                }
                
                // Update carousel state
                function updateCarouselState() {
                    // Enable/disable prev button
                    if (currentPosition <= 0) {
                        $prev.addClass('disabled');
                    } else {
                        $prev.removeClass('disabled');
                    }
                    
                    // Enable/disable next button
                    if (currentPosition >= maxScroll) {
                        $next.addClass('disabled');
                    } else {
                        $next.removeClass('disabled');
                    }
                }
            });
        }
    }

})(jQuery);
