/**
 * JavaScript functions for bonus features
 * 
 * Includes:
 * - Copy bonus code functionality
 * - Toggle full terms display
 * - Bonus code reveal animations
 */

(function($) {
    'use strict';

    // Variables
    var $window = $(window),
        $document = $(document);

    // DOM Ready
    $(function() {
        initCopyCode();
        initFullTerms();
        initCodeReveal();
    });

    /**
     * Initialize copy code functionality
     */
    function initCopyCode() {
        $('.copy-code-btn').on('click', function() {
            var $this = $(this),
                $codeText = $this.siblings('#bonus-code-text'),
                code = $codeText.text().trim(),
                originalText = $this.html(),
                successText = '<i class="fa-solid fa-check"></i> ' + casino_review_vars.copied_text;
            
            // Create temporary element for copying
            var $temp = $('<textarea>');
            $('body').append($temp);
            $temp.val(code).select();
            
            try {
                // Copy text
                document.execCommand('copy');
                
                // Show success message
                $this.html(successText);
                
                // Highlight the code
                $codeText.addClass('copied');
                
                // Reset after 2 seconds
                setTimeout(function() {
                    $this.html(originalText);
                    $codeText.removeClass('copied');
                }, 2000);
            } catch (err) {
                console.error('Failed to copy: ', err);
            }
            
            // Remove temporary element
            $temp.remove();
        });
    }

    /**
     * Initialize read full terms functionality
     */
    function initFullTerms() {
        $('.read-full-terms').on('click', function(e) {
            e.preventDefault();
            
            // Smooth scroll to terms section
            $('html, body').animate({
                scrollTop: $('.bonus-terms-box').offset().top - 100
            }, 800);
        });
    }

    /**
     * Initialize bonus code reveal animations
     */
    function initCodeReveal() {
        // Check if we have bonus codes in lists
        if ($('.bonus-code').length) {
            $('.bonus-code').each(function() {
                var $code = $(this),
                    codeText = $code.text(),
                    maskedText = '●●●●●●';
                
                // Initially mask the code
                if (!$code.hasClass('revealed')) {
                    $code.data('code', codeText);
                    $code.text(maskedText);
                    $code.addClass('masked');
                    
                    // Add reveal button
                    $code.after('<button class="reveal-code-btn"><i class="fa-solid fa-eye"></i></button>');
                }
            });
            
            // Reveal code on click
            $(document).on('click', '.reveal-code-btn', function() {
                var $btn = $(this),
                    $code = $btn.prev('.bonus-code');
                
                if ($code.hasClass('masked')) {
                    // Reveal the code
                    $code.text($code.data('code'));
                    $code.removeClass('masked').addClass('revealed');
                    $btn.html('<i class="fa-solid fa-eye-slash"></i>');
                } else {
                    // Hide the code again
                    $code.text('●●●●●●');
                    $code.removeClass('revealed').addClass('masked');
                    $btn.html('<i class="fa-solid fa-eye"></i>');
                }
            });
        }
    }

})(jQuery);
