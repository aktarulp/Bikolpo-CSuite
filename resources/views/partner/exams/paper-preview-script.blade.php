<style>
    #livePreview.landscape {
        writing-mode: horizontal-tb;
    }
    
    #livePreview.portrait {
        writing-mode: horizontal-tb;
    }
    
         #livePreview {
         margin: 0 auto;
         display: block;
         overflow: visible;
     }
     
   
    
        /* Paper Column Layout Styles - removed old grid layout that was causing page splitting */
    
                                                                               /* Ensure content doesn't break awkwardly in columns */
        #livePreview > div {
            break-inside: avoid;
            page-break-inside: avoid;
        }
        
     
     
                          /* Header container styling */
        .header-container {
            background: rgba(248, 250, 252, 0.8);
            border-radius: 4px;
            padding: 5px;
            margin-bottom: 8px;
            grid-column: 1 / -1; /* Default to span all columns */
            height: auto !important;
            min-height: auto !important;
            align-self: start;
        }
        
        /* Header span styles for different configurations */
        #livePreview .header-container[style*="grid-column: 1 / 2"] {
            grid-column: 1 / 2 !important;
            background: rgba(59, 130, 246, 0.1) !important; /* Blue tint for 1 column span */
        }
        
        #livePreview .header-container[style*="grid-column: 1 / 3"] {
            grid-column: 1 / 3 !important;
            background: rgba(16, 185, 129, 0.1) !important; /* Green tint for 2 column span */
        }
        
        #livePreview .header-container[style*="grid-column: 1 / 4"] {
            grid-column: 1 / 4 !important;
            background: rgba(245, 158, 11, 0.1) !important; /* Orange tint for 3 column span */
        }
        
        #livePreview .header-container[style*="grid-column: 1 / 5"] {
            grid-column: 1 / 5 !important;
            background: rgba(239, 68, 68, 0.1) !important; /* Red tint for 4 column span */
        }
        
                /* Page container styling */
        #livePreview .page-container {
            background: white;
            margin: 0;
            padding: 0;
            border-radius: 0;
            page-break-inside: avoid;
            break-inside: avoid;
            border-green-500;
            box-sizing: border-box;
            position: relative;
        }
        
        /* A4 aspect ratio maintenance */
        #livePreview .page-container.a4-portrait {
            width: 210mm;
            min-height: 297mm;
            border: 2px solid #3b82f6; /* Blue border for A4 */
        }
        
        #livePreview .page-container.a4-landscape {
            width: 297mm;
            min-height: 210mm;
            border: 2px solid #3b82f6; /* Blue border for A4 */
        }
        
        /* Letter size */
        #livePreview .page-container.letter-portrait {
            width: 216mm;
            min-height: 279mm;
            border: 2px solid #10b981; /* Green border for Letter */
        }
        
        #livePreview .page-container.letter-landscape {
            width: 279mm;
            min-height: 216mm;
            border: 2px solid #10b981; /* Green border for Letter */
        }
        
        /* Legal size */
        #livePreview .page-container.legal-portrait {
            width: 216mm;
            min-height: 356mm;
            border: 2px solid #f59e0b; /* Orange border for Legal */
        }
        
        #livePreview .page-container.legal-landscape {
            width: 356mm;
            min-height: 216mm;
            border: 2px solid #f59e0b; /* Orange border for Legal */
        }
        
        
        /* Dynamic preview container sizing based on paper size */
        #livePreview.preview-a4 {
            max-width: 800px;
        }
        
        #livePreview.preview-letter {
            max-width: 820px;
        }
        
        #livePreview.preview-legal {
            max-width: 820px;
        }
        
        #livePreview.preview-a4-landscape,
        #livePreview.preview-letter-landscape,
        #livePreview.preview-legal-landscape {
            max-width: 1100px;
        }
        
        /* Responsive scaling for smaller screens */
        @media (max-width: 1200px) {
            #livePreview .page-container {
                transform: scale(0.8);
                transform-origin: top center;
            }
            #livePreview.preview-a4-landscape,
            #livePreview.preview-letter-landscape,
            #livePreview.preview-legal-landscape {
                max-width: 900px;
            }
        }
        
        @media (max-width: 900px) {
            #livePreview .page-container {
                transform: scale(0.6);
                transform-origin: top center;
            }
            #livePreview.preview-a4,
            #livePreview.preview-letter,
            #livePreview.preview-legal {
                max-width: 600px;
            }
            #livePreview.preview-a4-landscape,
            #livePreview.preview-letter-landscape,
            #livePreview.preview-legal-landscape {
                max-width: 700px;
            }
        }
        
        @media (max-width: 600px) {
            #livePreview .page-container {
                transform: scale(0.4);
                transform-origin: top center;
            }
            #livePreview.preview-a4,
            #livePreview.preview-letter,
            #livePreview.preview-legal,
            #livePreview.preview-a4-landscape,
            #livePreview.preview-letter-landscape,
            #livePreview.preview-legal-landscape {
                max-width: 100%;
            }
        }
        
        /* Margin area visualization */
        .page-container {
            position: relative;
        }
        
        /* Margin area grid - shows area outside margins */
        .margin-area-grid {
            position: absolute;
            pointer-events: none;
            z-index: 0;
            background: rgba(255, 0, 0, 0.2);
        }
        
        /* Content area - shows printable area within margins */
        .content-area {
            position: absolute;
            background: rgba(0, 255, 0, 0.1);
            border: 2px solid rgba(0, 255, 0, 0.5);
            pointer-events: none;
            z-index: 1;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            padding: 0;
            box-sizing: border-box;
        }
        
        
        /* Multi-column layout within pages - now handled by questions-grid */
        #livePreview .questions-grid {
            display: grid !important;
            gap: 10px !important;
            position: relative;
        }
        
        #livePreview .questions-grid[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr 1fr !important;
        }
        
        #livePreview .questions-grid[style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr 1fr 1fr !important;
        }
        
        /* Question column styling */
        #livePreview .question-column {
            min-width: 0;
            padding: 0 5px;
            border: 1px dashed #ccc;
            background: rgba(0, 0, 0, 0.02);
            min-height: 100px;
        }
        
        
        /* Column separator styling */
        #livePreview .column-separator {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 1px;
            background: #333;
            opacity: 0.3;
            z-index: 1;
        }
        
        /* Question styling */
        #livePreview .question {
            margin-bottom: 8px;
            padding: 5px;
            border-left: 2px solid #3b82f6;
            background: #f8fafc;
            border-radius: 2px;
        }
        
        /* Header styling */
        #livePreview .header-container {
            background: #f1f5f9;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        
        /* Page title styling */
        #livePreview .page-title {
            background: #3b82f6;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
            font-weight: bold;
        }
        
        /* Continuous page layout - no pagination needed */
        
        /* Ensure questions don't break across grid columns */
     .header-container[style*="grid-column"] {
         width: 100%;
     }
     
        /* Scaling functionality */
     .adjust-to-percentage {
         transform: scale(var(--adjust-percentage, 1)) !important;
         transform-origin: center !important;
     }
     
     /* Paper Container Layout - matching PHP method */
     .paper-container {
         background: white;
         border: 2px solid #3b82f6;
         margin: 0 auto;
         display: grid;
         gap: 20px;
         padding: 20px;
         box-sizing: border-box;
         position: relative;
         page-break-inside: avoid;
         break-inside: avoid;
     }
     
     .paper-container.paper-columns-1 {
         grid-template-columns: 1fr;
     }
     
     .paper-container.paper-columns-2 {
         grid-template-columns: 1fr 1fr;
         gap: 10px;
         padding: 15px;
     }
     
     .paper-container.paper-columns-3 {
         grid-template-columns: 1fr 1fr 1fr;
         gap: 10px;
         padding: 15px;
     }
     
     .paper-container.paper-columns-4 {
         grid-template-columns: 1fr 1fr 1fr 1fr;
         gap: 10px;
         padding: 15px;
     }
     
     /* Question column containers for sequential filling */
     .paper-container .question-column {
         display: flex;
         flex-direction: column;
         min-height: 0;
         background: rgba(248, 250, 252, 0.3);
         border: 1px dashed #cbd5e1;
         border-radius: 4px;
         padding: 10px;
         margin-bottom: 5px;
     }
     
     .paper-container .question-column[data-column="1"] {
         background: rgba(239, 246, 255, 0.5); /* Blue tint for first column */
     }
     
     .paper-container .question-column[data-column="2"] {
         background: rgba(236, 253, 245, 0.5); /* Green tint for second column */
     }
     
     .paper-container .question-column[data-column="3"] {
         background: rgba(255, 251, 235, 0.5); /* Yellow tint for third column */
     }
     
     .paper-container .question-column[data-column="4"] {
         background: rgba(254, 242, 242, 0.5); /* Red tint for fourth column */
     }
     
     /* Footer spanning all columns */
     .paper-container .footer {
         margin-top: 40px;
         text-align: center;
         color: #666;
         border-top: 1px solid #ccc;
         padding-top: 20px;
         font-size: 0.9em;
     }
     
     /* Header Container */
     .paper-container .header-container {
         text-align: center;
         border-bottom: 2px solid #333;
         padding-bottom: 15px;
         margin-bottom: 20px;
         background: rgba(248, 250, 252, 0.8);
         border-radius: 4px;
         padding: 15px;
     }
     
     .paper-container .exam-title {
         font-weight: bold;
         margin-bottom: 10px;
     }
     
     .paper-container .exam-info {
         color: #666;
     }
     
     .paper-container .question-header {
         margin: 15px 0;
         padding: 15px;
         background: #f9f9f9;
         border-radius: 5px;
     }
     
     /* Question styling within paper container */
     .paper-container .question {
         margin-bottom: 10px;
         page-break-inside: avoid;
         break-inside: avoid;
     }
     
     .paper-container .question-number {
         font-weight: bold;
         color: #333;
     }
     
     .paper-container .question-text {
         margin: 5px 0;
     }
     
     .paper-container .marks {
         font-weight: bold;
         color: #333;
         float: right;
     }
     
     /* MCQ Options Grid */
     .paper-container .mcq-options {
         display: grid;
         gap: 10px;
         margin: 5px 0;
     }
     
     .paper-container .mcq-options.columns-1 { grid-template-columns: 1fr; }
     .paper-container .mcq-options.columns-2 { grid-template-columns: 1fr 1fr; }
     .paper-container .mcq-options.columns-3 { grid-template-columns: 1fr 1fr 1fr; }
     .paper-container .mcq-options.columns-4 { grid-template-columns: 1fr 1fr 1fr 1fr; }
     
     .paper-container .option {
         margin: 5px 0;
     }
     
     /* Paper size specific styling for preview */
     #livePreview .paper-container {
         max-width: 800px;
         min-height: 600px;
     }
     
     /* A4 dimensions */
     #livePreview.preview-a4 .paper-container {
         width: 210mm;
         min-height: 297mm;
     }
     
     #livePreview.preview-a4-landscape .paper-container {
         width: 297mm;
         min-height: 210mm;
     }
     
     /* Letter dimensions */
     #livePreview.preview-letter .paper-container {
         width: 216mm;
         min-height: 279mm;
         border-color: #10b981;
     }
     
     #livePreview.preview-letter-landscape .paper-container {
         width: 279mm;
         min-height: 216mm;
         border-color: #10b981;
     }
     
     /* Legal dimensions */
     #livePreview.preview-legal .paper-container {
         width: 216mm;
         min-height: 356mm;
         border-color: #f59e0b;
     }
     
     #livePreview.preview-legal-landscape .paper-container {
         width: 356mm;
         min-height: 216mm;
         border-color: #f59e0b;
     }
     
</style>

<script>
// Live preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const previewContainer = document.getElementById('livePreview');
    const form = document.getElementById('parameterForm');
    
    // Define updatePreview function first
    function updatePreview() {
        try {
            console.log('🚀 updatePreview called');
            
            // Get elements fresh to avoid scope issues
            const currentForm = document.getElementById('parameterForm');
            const currentPreviewContainer = document.getElementById('livePreview');
            
            // Check if form exists
            if (!currentForm) {
                console.error('❌ Form not found!');
                return;
            }
            
            // Check if previewContainer exists
            if (!currentPreviewContainer) {
                console.error('❌ Preview container not found!');
                return;
            }
            
            console.log('✅ Both form and previewContainer found');
        
            // First, let's clear the placeholder message
            currentPreviewContainer.innerHTML = '<div class="text-center text-blue-500 py-4">🔄 Generating preview...</div>';
            console.log('🔄 Cleared placeholder message');
        
            const formData = new FormData(currentForm);
            const params = Object.fromEntries(formData.entries());
            console.log('📋 Form params:', params);

            // Make an AJAX call to get the rendered Blade view
            fetch('{{ route('partner.exams.print-paper-preview', $exam) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(params)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(html => {
                currentPreviewContainer.innerHTML = html;
                console.log('✅ Preview content set successfully');

                // After content is loaded, re-apply styles based on current form parameters
                const paperContainer = currentPreviewContainer.querySelector('.paper-container');
                if (paperContainer) {
                    paperContainer.style.fontFamily = `'${params.font_family || 'Arial'}'`;
                    paperContainer.style.fontSize = `${params.font_size || 12}pt`;
                    paperContainer.style.lineHeight = params.line_spacing || 1.5;
                    paperContainer.style.transform = `scale(${(params.adjust_to_percentage || 100) / 100})`;

                    // Update paper columns class
                    paperContainer.classList.forEach(cls => {
                        if (cls.startsWith('paper-columns-')) {
                            paperContainer.classList.remove(cls);
                        }
                    });
                    paperContainer.classList.add(`paper-columns-${params.paper_columns || 1}`);

                    // Update header and footer visibility
                    const header = paperContainer.querySelector('.paper-header');
                    const footer = paperContainer.querySelector('.paper-footer');

                    if (header) {
                        header.style.display = (params.include_header === '1' || params.include_header === true) ? 'block' : 'none';
                    }
                    if (footer) {
                        footer.style.display = (params.show_page_number === '1' || params.show_page_number === true) ? 'block' : 'none';
                    }

                    console.log('✅ Applied dynamic styles to paper container');
                }
            })
            .catch(error => {
                console.error('❌ Error fetching preview:', error);
                currentPreviewContainer.innerHTML = `
                    <div class="text-center text-red-500 py-8">
                        <svg class="w-12 h-12 mx-auto mb-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <p class="text-lg font-medium">Preview Generation Failed</p>
                        <p class="text-sm">Error: ${error.message}</p>
                        <p class="text-xs text-gray-500 mt-2">Check console for details</p>
                    </div>
                `;
            });

            // Apply paper format settings to preview container
            const paperSize = params.paper_size || 'A4';
            const orientation = params.orientation || 'portrait';
            
            // Update preview container classes based on paper size and orientation
            if (currentPreviewContainer) {
                currentPreviewContainer.classList.remove('preview-a4', 'preview-letter', 'preview-legal', 'preview-a4-landscape', 'preview-letter-landscape', 'preview-legal-landscape');
                const previewClass = `preview-${paperSize.toLowerCase()}${orientation === 'landscape' ? '-landscape' : ''}`;
                currentPreviewContainer.classList.add(previewClass);
                
                // Removed direct style manipulation for width and height
                // as these are now handled by CSS classes in paper-preview-styles.blade.php

                // Update the paper size indicator
                const paperSizeIndicator = document.getElementById('currentPaperSize');
                if (paperSizeIndicator) {
                    const displayText = `${paperSize} ${orientation.charAt(0).toUpperCase() + orientation.slice(1)}`;
                    paperSizeIndicator.textContent = displayText;
                    
                    // Update indicator color based on paper size
                    paperSizeIndicator.className = 'text-xs font-medium px-2 py-1 rounded';
                    if (paperSize === 'A4') {
                        paperSizeIndicator.classList.add('text-blue-600', 'bg-blue-100');
                    } else if (paperSize === 'Letter') {
                        paperSizeIndicator.classList.add('text-green-600', 'bg-green-100');
                    } else if (paperSize === 'Legal') {
                        paperSizeIndicator.classList.add('text-orange-600', 'bg-orange-100');
                    }
                }
            }
        } catch (error) {
            console.error('❌ Fatal error in updatePreview:', error);
            const errorPreviewContainer = document.getElementById('livePreview');
            if (errorPreviewContainer) {
                errorPreviewContainer.innerHTML = `
                    <div class="text-center text-red-500 py-8">
                        <svg class="w-12 h-12 mx-auto mb-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <p class="text-lg font-medium">Preview Error</p>
                        <p class="text-sm">Fatal error: ${error.message}</p>
                        <p class="text-xs text-gray-500 mt-2">Check console for details</p>
                    </div>
                `;
            }
        }
    }
    
    // Load saved settings if available
    loadSavedSettings();
    
    // Apply default preview container sizing if no saved settings
    setTimeout(() => {
        const previewContainer = document.getElementById('livePreview');
        if (previewContainer && !previewContainer.classList.contains('preview-a4') && 
            !previewContainer.classList.contains('preview-letter') && 
            !previewContainer.classList.contains('preview-legal')) {
            previewContainer.classList.add('preview-a4'); // Default to A4
            console.log('📦 Default preview container class applied: preview-a4');
        }
        
        // Trigger initial preview update
        updatePreview();
    }, 200);
    
    // Add event listeners to all form inputs
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('change', updatePreview);
        input.addEventListener('input', updatePreview);
    });
    
    // PDF Download functionality
    const downloadPdfBtn = document.getElementById('downloadPdfBtn');
    if (downloadPdfBtn) {
        downloadPdfBtn.addEventListener('click', function() {
            downloadPDF();
        });
    }
    
    // Save Settings functionality
    const saveSettingsBtn = document.getElementById('saveSettingsBtn');
    if (saveSettingsBtn) {
        saveSettingsBtn.addEventListener('click', function() {
            saveSettings();
        });
    }
    
    // Function to save settings
    function saveSettings() {
        const saveBtn = document.getElementById('saveSettingsBtn');
        const originalText = saveBtn.innerHTML;
        
        // Show loading state
        saveBtn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span>Saving...</span>
        `;
        saveBtn.disabled = true;
        
        try {
            // Get form parameters
            const formData = new FormData(form);
            const params = Object.fromEntries(formData.entries());
            
            // Convert checkboxes to proper boolean values
            params.include_header = params.include_header === '1';
            params.mark_answer = params.mark_answer === '1';
            params.show_page_number = params.show_page_number === '1';

            // Send to server for saving
            fetch('{{ route("partner.exams.save-paper-settings", $exam) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    parameters: params
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Show success message
                saveBtn.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Saved!</span>
                `;
                saveBtn.classList.remove('from-green-500', 'to-emerald-600', 'hover:from-green-600', 'hover:to-emerald-700');
                saveBtn.classList.add('from-green-600', 'to-green-700');
                
                setTimeout(() => {
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                    saveBtn.classList.remove('from-green-600', 'to-green-700');
                    saveBtn.classList.add('from-green-500', 'to-emerald-600', 'hover:from-green-600', 'hover:to-emerald-700');
                }, 2000);
            })
            .catch(error => {
                console.error('Save Settings Error:', error);
                
                // Show error message
                saveBtn.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Failed!</span>
                `;
                saveBtn.classList.remove('from-green-500', 'to-emerald-600', 'hover:from-green-600', 'hover:to-emerald-700');
                saveBtn.classList.add('from-red-500', 'to-red-600');
                
                setTimeout(() => {
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                    saveBtn.classList.remove('from-red-500', 'to-red-600');
                    saveBtn.classList.add('from-green-500', 'to-emerald-600', 'hover:from-green-600', 'hover:to-emerald-700');
                }, 3000);
                
                alert('Failed to save settings: ' + error.message + '\n\nPlease try again.');
            });
        } catch (error) {
            console.error('Error preparing settings:', error);
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
            alert('Error preparing settings for save.');
        }
    }
    
    // Function to load saved settings
    function loadSavedSettings() {
        @if(isset($savedSettings) && !empty($savedSettings))
            const savedSettings = {{ Js::from($savedSettings) }};
            console.log('Loading saved settings:', savedSettings);
            
            // Populate form fields with saved settings
            Object.keys(savedSettings).forEach(key => {
                const element = document.getElementById(key) || document.querySelector(`[name="${key}"]`);
                if (element) {
                    if (element.type === 'checkbox') {
                        element.checked = Boolean(savedSettings[key]);
                    } else if (element.type === 'number') {
                        element.value = savedSettings[key];
                    } else if (element.tagName === 'SELECT') {
                        element.value = savedSettings[key];
                    } else {
                        element.value = savedSettings[key];
                    }
                }
            });
            
            // Update preview after loading settings
            setTimeout(() => {
                updatePreview();
            }, 100);
            
            // Apply initial preview container sizing
            setTimeout(() => {
                const paperSize = savedSettings.paper_size || 'A4';
                const orientation = savedSettings.orientation || 'portrait';
                const previewContainer = document.getElementById('livePreview');
                if (previewContainer) {
                    previewContainer.classList.remove('preview-a4', 'preview-letter', 'preview-legal', 'preview-a4-landscape', 'preview-letter-landscape', 'preview-legal-landscape');
                    const previewClass = `preview-${paperSize.toLowerCase()}${orientation === 'landscape' ? '-landscape' : ''}`;
                    previewContainer.classList.add(previewClass);
                    
                    // Update the paper size indicator
                    const paperSizeIndicator = document.getElementById('currentPaperSize');
                    if (paperSizeIndicator) {
                        const displayText = `${paperSize} ${orientation.charAt(0).toUpperCase() + orientation.slice(1)}`;
                        paperSizeIndicator.textContent = displayText;
                        
                        // Update indicator color based on paper size
                        paperSizeIndicator.className = 'text-xs font-medium px-2 py-1 rounded';
                        if (paperSize === 'A4') {
                            paperSizeIndicator.classList.add('text-blue-600', 'bg-blue-100');
                        } else if (paperSize === 'Letter') {
                            paperSizeIndicator.classList.add('text-green-600', 'bg-green-100');
                        } else if (paperSize === 'Legal') {
                            paperSizeIndicator.classList.add('text-orange-600', 'bg-orange-100');
                        }
                    }
                }
            }, 150);
        @endif
    }
    
    
    // Function to download PDF
    function downloadPDF() {
        const downloadBtn = document.getElementById('downloadPdfBtn');
        const originalText = downloadBtn.innerHTML;
        
        // Show loading state
        downloadBtn.innerHTML = '⏳ Generating PDF...';
        downloadBtn.disabled = true;
        
        try {
            const form = document.getElementById('parameterForm');
            const formData = new FormData(form);
            const params = Object.fromEntries(formData.entries());

            // Send to server for PDF generation
            fetch('{{ route("partner.exams.download-paper", $exam) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    parameters: params
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.blob();
            })
            .then(blob => {
                // Create download link
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'question_paper_{{ $exam->id }}_' + new Date().toISOString().slice(0,19).replace(/:/g, '-') + '.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
                
                // Show success message
                downloadBtn.innerHTML = '✅ PDF Downloaded!';
                setTimeout(() => {
                    downloadBtn.innerHTML = originalText;
                    downloadBtn.disabled = false;
                }, 2000);
            })
            .catch(error => {
                console.error('PDF Generation Error:', error);
                
                // Show error message
                downloadBtn.innerHTML = '❌ Failed to Generate PDF';
                setTimeout(() => {
                    downloadBtn.innerHTML = originalText;
                    downloadBtn.disabled = false;
                }, 3000);
                
                alert('Failed to generate PDF: ' + error.message + '\n\nPlease try again or contact support if the problem persists.');
            });
        } catch (error) {
            console.error('PDF Download Error:', error);
            downloadBtn.innerHTML = '❌ Download Error';
            setTimeout(() => {
                downloadBtn.innerHTML = originalText;
                downloadBtn.disabled = false;
            }, 3000);
            alert('Failed to prepare PDF download. Please refresh the page and try again.');
        }
    }
});
</script>
