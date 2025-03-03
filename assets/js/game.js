/**
 * JavaScript functions for game features
 * 
 * Includes:
 * - Game filtering functionality
 * - Casino list expansion
 * - Game screenshots gallery
 */

(function($) {
    'use strict';

    // Variables
    var $window = $(window),
        $document = $(document);

    // DOM Ready
    $(function() {
        initCasinoList();
        initGameFilters();
        initGameGallery();
        initGameRating();
    });

    /**
     * Initialize casino list functionality
     */
    function initCasinoList() {
        // View all casinos button
        $('.view-all-casinos-btn').on('click', function() {
            var $this = $(this),
                originalText = $this.text(),
                lessText = casino_review_vars.less_text || 'Show Less',
                $casinoList = $('.game-casinos .casino-list-small');
            
            if ($casinoList.hasClass('expanded')) {
                // Collapse the list
                $casinoList.removeClass('expanded');
                $this.text(originalText);
                
                // Scroll back to top of list
                $('html, body').animate({
                    scrollTop: $('.game-casinos').offset().top - 100
                }, 500);
            } else {
                // Expand the list
                $casinoList.addClass('expanded');
                $this.text(lessText);
            }
        });
        
        // Play at casinos button
        $('.play-at-casinos-btn').on('click', function() {
            // Smooth scroll to casinos section
            $('html, body').animate({
                scrollTop: $('.game-casinos').offset().top - 100
            }, 800);
        });
    }

    /**
     * Initialize game filters functionality
     */
    function initGameFilters() {
        // Quick filter buttons
        $('.quick-filter-btn').on('click', function(e) {
            e.preventDefault();
            
            var $this = $(this),
                filterType = $this.data('filter-type'),
                filterValue = $this.data('filter-value'),
                $form = $('.filter-form');
            
            // Set the form value
            $form.find('#filter-' + filterType).val(filterValue);
            
            // Submit the form
            $form.submit();
        });
        
        // Game layout toggle
        $('.layout-toggle').on('click', function(e) {
            e.preventDefault();
            
            var $this = $(this),
                layout = $this.data('layout'),
                $gamesGrid = $('.games-grid');
            
            // Remove active class from all buttons
            $('.layout-toggle').removeClass('active');
            
            // Add active class to clicked button
            $this.addClass('active');
            
            // Update grid class
            $gamesGrid.removeClass('grid-layout list-layout');
            $gamesGrid.addClass(layout + '-layout');
            
            // Store preference in localStorage
            if (typeof(Storage) !== "undefined") {
                localStorage.setItem('casino_review_game_layout', layout);
            }
        });
        
        // Load saved layout preference
        if (typeof(Storage) !== "undefined" && $('.games-grid').length) {
            var savedLayout = localStorage.getItem('casino_review_game_layout');
            
            if (savedLayout) {
                // Update toggle buttons
                $('.layout-toggle').removeClass('active');
                $('.layout-toggle[data-layout="' + savedLayout + '"]').addClass('active');
                
                // Update grid class
                $('.games-grid').removeClass('grid-layout list-layout');
                $('.games-grid').addClass(savedLayout + '-layout');
            }
        }
    }

    /**
     * Initialize game screenshots gallery
     */
    function initGameGallery() {
        // Check if game gallery exists
        if ($('.game-screenshots').length) {
            // Initialize lightbox
            $('.screenshot-item').on('click', function(e) {
                e.preventDefault();
                
                var $this = $(this),
                    imageUrl = $this.data('full-image'),
                    imageTitle = $this.find('img').attr('alt');
                
                // Create lightbox overlay
                var $lightbox = $('<div class="lightbox-overlay"></div>');
                var $lightboxContent = $('<div class="lightbox-content"></div>');
                var $lightboxClose = $('<button class="lightbox-close"><i class="fa-solid fa-times"></i></button>');
                var $lightboxImage = $('<img src="' + imageUrl + '" alt="' + imageTitle + '" class="lightbox-image">');
                var $lightboxCaption = $('<div class="lightbox-caption">' + imageTitle + '</div>');
                
                // Add elements to DOM
                $lightboxContent.append($lightboxClose, $lightboxImage, $lightboxCaption);
                $lightbox.append($lightboxContent);
                $('body').append($lightbox);
                
                // Prevent scrolling
                $('body').addClass('lightbox-open');
                
                // Close on button click
                $lightboxClose.on('click', function() {
                    $lightbox.remove();
                    $('body').removeClass('lightbox-open');
                });
                
                // Close on overlay click
                $lightbox.on('click', function(e) {
                    if (e.target === this) {
                        $lightbox.remove();
                        $('body').removeClass('lightbox-open');
                    }
                });
                
                // Close on ESC key
                $(document).on('keyup.lightbox', function(e) {
                    if (e.key === "Escape") {
                        $lightbox.remove();
                        $('body').removeClass('lightbox-open');
                        $(document).off('keyup.lightbox');
                    }
                });
            });
        }
    }

    /**
     * Initialize game rating user interaction
     */
    function initGameRating() {
        // User can rate games
        if ($('.user-rating-stars').length) {
            $('.user-rating-stars .star').on('mouseenter', function() {
                var $this = $(this),
                    index = $this.index(),
                    $stars = $this.parent().find('.star');
                
                // Highlight stars
                $stars.removeClass('active hover');
                $stars.each(function(i) {
                    if (i <= index) {
                        $(this).addClass('hover');
                    }
                });
            }).on('mouseleave', function() {
                var $this = $(this),
                    $stars = $this.parent().find('.star');
                
                // Remove hover class
                $stars.removeClass('hover');
            }).on('click', function() {
                var $this = $(this),
                    index = $this.index(),
                    rating = index + 1,
                    $stars = $this.parent().find('.star'),
                    $container = $this.closest('.user-rating-container'),
                    gameId = $container.data('game-id'),
                    nonce = $container.data('nonce');
                
                // Highlight stars
                $stars.removeClass('active');
                $stars.each(function(i) {
                    if (i <= index) {
                        $(this).addClass('active');
                    }
                });
                
                // Update hidden input
                $container.find('input[name="user_rating"]').val(rating);
                
                // Show thank you message
                $container.find('.rating-message').html('<i class="fa-solid fa-check"></i> ' + casino_review_vars.thanks_rating);
                
                // Submit rating via AJAX
                if (gameId && nonce) {
                    $.ajax({
                        url: casino_review_vars.ajaxurl,
                        type: 'post',
                        data: {
                            action: 'rate_game',
                            game_id: gameId,
                            rating: rating,
                            nonce: nonce
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update average rating if returned
                                if (response.data && response.data.average) {
                                    $('.game-rating-score').text(response.data.average);
                                    
                                    // Update stars
                                    updateRatingStars(response.data.average);
                                }
                            }
                        }
                    });
                }
            });
        }
    }

    /**
     * Update rating stars based on average rating
     */
    function updateRatingStars(average) {
        var $ratingStars = $('.game-rating-stars .rating-stars'),
            starsHtml = '',
            fullStars = Math.floor(average / 2),
            halfStar = (average / 2) - fullStars >= 0.5,
            emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
        
        // Full stars
        for (var i = 0; i < fullStars; i++) {
            starsHtml += '<span class="star filled"><i class="fa-solid fa-star"></i></span>';
        }
        
        // Half star
        if (halfStar) {
            starsHtml += '<span class="star filled"><i class="fa-solid fa-star-half-stroke"></i></span>';
        }
        
        // Empty stars
        for (var j = 0; j < emptyStars; j++) {
            starsHtml += '<span class="star"><i class="fa-regular fa-star"></i></span>';
        }
        
        // Update stars HTML
        $ratingStars.html(starsHtml);
    }

})(jQuery);
