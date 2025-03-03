/**
 * JavaScript functions for the Casino Comparison tool
 * 
 * Features:
 * - Tab navigation
 * - Casino selection
 * - Mobile responsive tables
 */

(function($) {
    'use strict';

    // Variables
    var $window = $(window),
        $document = $(document);

    // DOM Ready
    $(function() {
        initComparisonTabs();
        initCasinoSelection();
        initResponsiveTables();
        initHighlightDifferences();
    });

    /**
     * Initialize tab navigation for comparison tables
     */
    function initComparisonTabs() {
        var $tabButtons = $('.comparison-tabs .tab-button'),
            $tabContents = $('.comparison-tab-content');
        
        // Tab button click handler
        $tabButtons.on('click', function() {
            var $this = $(this),
                tabId = $this.data('tab');
            
            // Remove active class from all buttons and contents
            $tabButtons.removeClass('active');
            $tabContents.removeClass('active');
            
            // Add active class to clicked button and corresponding content
            $this.addClass('active');
            $('#' + tabId + '-tab').addClass('active');
            
            // Save active tab in session storage
            if (typeof(Storage) !== "undefined") {
                sessionStorage.setItem('active_comparison_tab', tabId);
            }
        });
        
        // Load active tab from session storage
        if (typeof(Storage) !== "undefined") {
            var activeTab = sessionStorage.getItem('active_comparison_tab');
            
            if (activeTab) {
                $tabButtons.filter('[data-tab="' + activeTab + '"]').trigger('click');
            }
        }
    }

    /**
     * Initialize casino selection functionality
     */
    function initCasinoSelection() {
        var $casinoSelect = $('#compare-casinos'),
            $hiddenInput = $('#casinos-hidden');
        
        // Initialize select2 plugin if available
        if ($.fn.select2) {
            $casinoSelect.select2({
                placeholder: casino_compare_vars.select_placeholder || 'Select casinos to compare',
                maximumSelectionLength: 4, // Maximum 4 casinos to compare
                width: '100%'
            });
            
            // Update hidden input with selected casinos on change
            $casinoSelect.on('change', function() {
                var selectedCasinos = $(this).val();
                $hiddenInput.val(selectedCasinos.join(','));
            });
        } else {
            // Fallback for when select2 is not available
            $casinoSelect.on('change', function() {
                var selectedCasinos = [];
                
                $casinoSelect.find('option:selected').each(function() {
                    selectedCasinos.push($(this).val());
                });
                
                $hiddenInput.val(selectedCasinos.join(','));
            });
        }
        
        // Handle "Add to Compare" links
        $('.add-to-compare-btn').on('click', function(e) {
            // Only prevent default if we can handle it with JS
            if ($.fn.select2) {
                e.preventDefault();
                
                var casinoId = $(this).data('casino-id'),
                    currentIds = $casinoSelect.val() || [];
                
                // Add the casino ID if not already selected
                if (currentIds.indexOf(casinoId.toString()) === -1) {
                    currentIds.push(casinoId.toString());
                    $casinoSelect.val(currentIds).trigger('change');
                    
                    // Scroll to the comparison form
                    $('html, body').animate({
                        scrollTop: $('.compare-selection-form').offset().top - 100
                    }, 500);
                }
            }
        });
    }

    /**
     * Initialize responsive tables for mobile view
     */
    function initResponsiveTables() {
        // Make comparison tables responsive on mobile
        if ($window.width() < 768) {
            makeTablesResponsive();
        }
        
        // Update on window resize
        $window.on('resize', function() {
            if ($window.width() < 768) {
                makeTablesResponsive();
            } else {
                resetTables();
            }
        });
        
        // Make tables responsive for mobile
        function makeTablesResponsive() {
            $('.comparison-table').each(function() {
                var $table = $(this);
                
                if (!$table.hasClass('responsive-ready')) {
                    // Add data attributes to cells for mobile view
                    $table.find('tbody tr').each(function() {
                        var $row = $(this),
                            featureName = $row.find('td.feature-name').text();
                        
                        $row.find('td.feature-value').attr('data-feature', featureName);
                    });
                    
                    // Add responsive class to table
                    $table.addClass('responsive-ready responsive-mode');
                } else {
                    $table.addClass('responsive-mode');
                }
            });
        }
        
        // Reset tables for desktop view
        function resetTables() {
            $('.comparison-table').removeClass('responsive-mode');
        }
    }

    /**
     * Highlight differences between casinos
     */
    function initHighlightDifferences() {
        // Add highlight button
        var $controlsContainer = $('.comparison-controls');
        
        if ($controlsContainer.length && !$controlsContainer.find('.highlight-differences-btn').length) {
            $controlsContainer.append('<button class="highlight-differences-btn">' + (casino_compare_vars.highlight_text || 'Highlight Differences') + '</button>');
        }
        
        // Toggle highlighting on button click
        $('.highlight-differences-btn').on('click', function() {
            var $this = $(this),
                $tables = $('.comparison-table');
            
            if ($tables.hasClass('highlight-differences')) {
                // Remove highlighting
                $tables.removeClass('highlight-differences');
                $tables.find('tr').removeClass('has-differences');
                $tables.find('td.feature-value').removeClass('different');
                $this.removeClass('active');
            } else {
                // Add highlighting
                $tables.addClass('highlight-differences');
                
                // Check for differences in each row
                $tables.find('tbody tr').each(function() {
                    var $row = $(this),
                        $cells = $row.find('td.feature-value'),
                        values = [];
                    
                    // Collect all values
                    $cells.each(function() {
                        values.push($(this).text().trim());
                    });
                    
                    // Check if there are any differences
                    var hasDifferences = false;
                    for (var i = 1; i < values.length; i++) {
                        if (values[i] !== values[0] && values[i] !== '—' && values[0] !== '—') {
                            hasDifferences = true;
                            break;
                        }
                    }
                    
                    // Add classes if differences found
                    if (hasDifferences) {
                        $row.addClass('has-differences');
                        $cells.addClass('different');
                    }
                });
                
                $this.addClass('active');
            }
        });
    }

})(jQuery);
