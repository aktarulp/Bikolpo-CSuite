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

        /* A4 aspect ratio maintenance - moved to .paper-container inside #livePreview */
        /* Letter size - moved to .paper-container inside #livePreview */
        /* Legal size - moved to .paper-container inside #livePreview */
        
        
        /* Dynamic preview container sizing based on paper size */
        #livePreview.preview-a4 {
            /* Dimensions now controlled by .paper-container inside */
            max-width: none; 
            max-height: none;
        }
        
        #livePreview.preview-letter {
            /* Dimensions now controlled by .paper-container inside */
            max-width: none;
            max-height: none;
        }
        
        #livePreview.preview-legal {
            /* Dimensions now controlled by .paper-container inside */
            max-width: none;
            max-height: none;
        }
        
        #livePreview.preview-a4-landscape {
            /* Dimensions now controlled by .paper-container inside */
            max-width: none;
            max-height: none;
        }
        
        #livePreview.preview-letter-landscape {
            /* Dimensions now controlled by .paper-container inside */
            max-width: none;
            max-height: none;
        }
        
        #livePreview.preview-legal-landscape {
            /* Dimensions now controlled by .paper-container inside */
            max-width: none;
            max-height: none;
        }

        /* Responsive scaling for smaller screens */
        @media (max-width: 1200px) {
            #livePreview {
                transform: scale(0.8);
                transform-origin: top center;
            }
        }
        
        @media (max-width: 900px) {
            #livePreview {
                transform: scale(0.6);
                transform-origin: top center;
            }
        }
        
        @media (max-width: 600px) {
            #livePreview {
                transform: scale(0.4);
                transform-origin: top center;
            }
            #livePreview {
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

     #livePreview.preview-a4 .paper-container {
         width: 210mm;
         min-height: 297mm;
     }
     
     #livePreview.preview-a4-landscape .paper-container {
         width: 297mm;
         min-height: 210mm;
     }
     
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
   470|</style>
