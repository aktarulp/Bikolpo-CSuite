@extends('layouts.partner-layout')

@section('title', 'Question Analytics - ' . $question->questionTypeText)

@section('content')
<style>
    /* Compact professional design */
    .question-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 0.75rem;
    }
    
    .question-card {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-radius: 8px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        margin-bottom: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    
    .question-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .question-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        border-color: #3b82f6;
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
    }
    
    .question-card:hover::before {
        opacity: 1;
    }
    
    .question-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        color: #1f2937;
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .question-card:hover .question-header {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    }
    
    .question-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #f3f4f6;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
    }
    
    .question-id-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #3b82f6;
        color: #ffffff;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.75rem;
        min-width: 2.5rem;
        height: 2.5rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }
    
    .question-id-badge:hover {
        background: #2563eb;
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
    }
    
    .question-content {
        padding: 1rem;
    }
    
    .question-text {
        font-size: 0.875rem;
        line-height: 1.2;
        color: #374151;
        margin-bottom: 1rem;
        word-wrap: break-word;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }
    
    .options-container {
        margin: 0.5rem 0;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
        visibility: visible;
    }
    
    .option-item {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        font-size: 0.75rem;
        position: relative;
        overflow: hidden;
    }
    
    .option-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .option-item:hover {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-color: #3b82f6;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
    }
    
    .option-item:hover::before {
        left: 100%;
    }
    
    .option-item.correct {
        background: #f0fdf4;
        border-color: #22c55e;
    }
    
    .option-letter {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 1.25rem;
        height: 1.25rem;
        background: #f3f4f6;
        color: #6b7280;
        border-radius: 3px;
        font-weight: 500;
        font-size: 0.625rem;
        flex-shrink: 0;
    }
    
    .option-item.correct .option-letter {
        background: #22c55e;
        color: white;
    }
    
    .option-text {
        font-size: 0.75rem;
        line-height: 1.2;
        color: #374151;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }
    
    .question-meta {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        padding: 0.75rem;
        border-radius: 6px;
        margin: 1rem 0;
        border: 1px solid #cbd5e1;
        transition: all 0.3s ease;
    }
    
    .question-card:hover .question-meta {
        background: linear-gradient(135deg, #e2e8f0 0%, #f1f5f9 100%);
        border-color: #94a3b8;
    }
    
    .meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.75rem;
    }
    
    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
    }
    
    .meta-label {
        font-size: 0.6875rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    
    .meta-value {
        font-size: 0.8125rem;
        color: #1f2937;
        font-weight: 500;
    }
    
    .explanation-section {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 1px solid #f59e0b;
        border-radius: 6px;
        padding: 1rem;
        margin: 1rem 0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .explanation-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.6s ease;
    }
    
    .explanation-section:hover {
        background: linear-gradient(135deg, #fde68a 0%, #fef3c7 100%);
        border-color: #d97706;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px -2px rgba(245, 158, 11, 0.3);
    }
    
    .explanation-section:hover::before {
        left: 100%;
    }
    
    .explanation-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #92400e;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }
    
    .explanation-content {
        font-size: 0.8125rem;
        line-height: 1.5;
        color: #92400e;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1.5rem;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        cursor: pointer;
        font-size: 0.8125rem;
        position: relative;
        overflow: hidden;
    }
    
    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .btn:hover::before {
        left: 100%;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(107, 114, 128, 0.3);
    }
    
    .btn-secondary:hover {
        background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.4);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(34, 197, 94, 0.3);
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4);
    }
    
    .btn-outline {
        background: linear-gradient(135deg, transparent 0%, rgba(59, 130, 246, 0.05) 100%);
        color: #3b82f6;
        border: 2px solid #3b82f6;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.1);
    }
    
    .btn-outline:hover {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }
    
    .image-container {
        margin: 1rem 0;
        text-align: center;
    }
    
    .question-image {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .difficulty-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .difficulty-easy {
        background: #dcfce7;
        color: #166534;
    }
    
    .difficulty-medium {
        background: #fef3c7;
        color: #92400e;
    }
    
    .difficulty-hard {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin: 1rem 0;
    }
    
    .tag {
        background: #e0e7ff;
        color: #3730a3;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .question-container {
            padding: 0.5rem;
        }
        
        .question-header {
            padding: 1rem;
        }
        
        .question-content {
            padding: 1rem;
        }
        
        .question-text {
            font-size: 1rem;
        }
        
        .option-item {
            padding: 0.5rem 0.75rem;
            gap: 0.5rem;
        }
        
        .option-letter {
            width: 1.25rem;
            height: 1.25rem;
            font-size: 0.625rem;
        }
        
        .option-text {
            font-size: 0.8125rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            justify-content: center;
            width: 100%;
        }
        
        .meta-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 480px) {
        .question-header h1 {
            font-size: 1.25rem;
        }
        
        .question-text {
            font-size: 0.95rem;
        }
        
        .option-item {
            padding: 0.5rem;
            gap: 0.5rem;
        }
        
        .option-letter {
            width: 1.125rem;
            height: 1.125rem;
            font-size: 0.625rem;
        }
        
        .option-text {
            font-size: 0.8125rem;
            line-height: 1.4;
        }
    }
    
    /* Loading states */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    /* Animation for correct answers */
    @keyframes correctAnswer {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .option-item.correct {
        animation: correctAnswer 0.6s ease-in-out;
    }
    
    /* Analytics Dashboard Styles */
    .analytics-dashboard {
        margin-top: 1.5rem;
    }
    
    .analytics-card {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .analytics-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .analytics-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        border-color: #3b82f6;
    }
    
    .analytics-card:hover::before {
        opacity: 1;
    }
    
    /* Professional Tab Navigation */
    .tab-navigation {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-bottom: 1px solid #e2e8f0;
        position: relative;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    
    .tab-navigation::-webkit-scrollbar {
        display: none;
    }
    
    .tab-navigation::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    }
    
    .tab-button {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        white-space: nowrap;
        min-width: fit-content;
        padding: 1rem 1.5rem;
        border-radius: 8px 8px 0 0;
        background: transparent;
        border: none;
        font-weight: 500;
        font-size: 0.875rem;
        color: #6b7280;
        border-bottom: 2px solid transparent;
        margin-right: 0.5rem;
    }
    
    .tab-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(147, 51, 234, 0.05));
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 8px 8px 0 0;
    }
    
    .tab-button:hover {
        color: #374151;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        transform: translateY(-1px);
    }
    
    .tab-button:hover::before {
        opacity: 1;
    }
    
    .tab-button.active {
        color: #1d4ed8;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-bottom-color: #3b82f6;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.1);
    }
    
    .tab-button.active::before {
        opacity: 1;
    }
    
    .tab-content {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }
    
    .tab-content.hidden {
        display: none;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Professional Tab Content */
    .tab-content-container {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        min-height: 400px;
        position: relative;
    }
    
    .tab-content-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    }
    
    /* Enhanced Metric Cards */
    .metric-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.05), transparent);
        transition: left 0.6s ease;
    }
    
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: #3b82f6;
    }
    
    .metric-card:hover::before {
        left: 100%;
    }
    
    /* Student Cards Enhancement */
    .student-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .student-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(34, 197, 94, 0.05), transparent);
        transition: left 0.6s ease;
    }
    
    .student-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #22c55e;
    }
    
    .student-card:hover::before {
        left: 100%;
    }
    
    .student-card.incorrect {
        border-color: #fecaca;
    }
    
    .student-card.incorrect:hover {
        border-color: #ef4444;
    }
    
    .student-card.incorrect::before {
        background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.05), transparent);
    }
    
    /* Activity Feed Enhancement */
    .activity-item {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .activity-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.05), transparent);
        transition: left 0.6s ease;
    }
    
    .activity-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: #3b82f6;
    }
    
    .activity-item:hover::before {
        left: 100%;
    }
    
    /* Student Performance Cards */
    .student-card {
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }
    
    .student-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.1);
    }
    
    /* Progress Bars */
    .progress-bar {
        transition: width 0.3s ease;
    }
    
    /* Mobile Responsive Enhancements */
    @media (max-width: 1024px) {
        .tab-navigation {
            padding: 0 1rem;
        }
        
        .tab-button {
            padding: 0.75rem 1rem;
            font-size: 0.8125rem;
            margin-right: 0.25rem;
        }
    }
    
    @media (max-width: 768px) {
        .tab-navigation {
            padding: 0 0.75rem;
        }
        
        .tab-button {
            padding: 0.625rem 0.75rem;
            font-size: 0.75rem;
            margin-right: 0.125rem;
        }
        
        .tab-content-container {
            padding: 1rem;
        }
        
        .metric-card {
            padding: 0.75rem;
        }
        
        .student-card {
            padding: 0.75rem;
        }
        
        .activity-item {
            padding: 0.5rem;
        }
    }
    
    @media (max-width: 640px) {
        .analytics-card {
            padding: 0.75rem;
        }
        
        .analytics-card .text-3xl {
            font-size: 1.5rem;
        }
        
        .tab-navigation {
            padding: 0 0.5rem;
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .tab-button {
            padding: 0.5rem 0.75rem;
            font-size: 0.6875rem;
            margin-right: 0.125rem;
            min-width: auto;
            flex-shrink: 0;
        }
        
        .tab-content-container {
            padding: 0.75rem;
        }
        
        .metric-card {
            padding: 0.625rem;
        }
        
        .student-card {
            padding: 0.625rem;
        }
        
        .activity-item {
            padding: 0.5rem;
        }
        
        .grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3 {
            grid-template-columns: 1fr;
        }
        
        .question-text {
            white-space: normal;
            line-height: 1.4;
        }
        
        .question-header .flex.items-center {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .question-header .flex.items-center .flex-1 {
            width: 100%;
        }
        
        /* Mobile-specific tab improvements */
        .tab-button.active {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            box-shadow: 0 1px 3px rgba(59, 130, 246, 0.2);
        }
        
        .tab-content {
            animation: slideIn 0.3s ease-in-out;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
    }
    
    @media (max-width: 480px) {
        .tab-navigation {
            padding: 0 0.25rem;
        }
        
        .tab-button {
            padding: 0.375rem 0.5rem;
            font-size: 0.625rem;
            margin-right: 0.0625rem;
        }
        
        .tab-content-container {
            padding: 0.5rem;
        }
        
        .metric-card {
            padding: 0.5rem;
        }
        
        .student-card {
            padding: 0.5rem;
        }
        
        .activity-item {
            padding: 0.375rem;
        }
        
        .text-3xl {
            font-size: 1.25rem;
        }
        
        .text-2xl {
            font-size: 1.125rem;
        }
        
        .text-lg {
            font-size: 1rem;
        }
    }
        
        .grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3 {
            grid-template-columns: 1fr;
        }
        
        .question-text {
            white-space: normal;
            line-height: 1.4;
        }
        
        .question-header .flex.items-center {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .question-header .flex.items-center .flex-1 {
            width: 100%;
        }
        
        .question-header .mt-1.flex.items-center {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .question-header .mt-2.flex.items-center {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .question-header .mt-2.flex.items-center.justify-between {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }
        
        .question-header .mt-2.flex.items-center.justify-between > div:first-child {
            width: 100%;
        }
        
        .question-header .flex.flex-col.gap-2 {
            align-items: flex-start;
        }
        
        .question-header .flex.items-center.gap-3 {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .question-header .question-text {
            width: 100%;
            margin-left: 0;
        }
        
        .question-id-badge {
            min-width: 2.5rem;
            height: 2.5rem;
            font-size: 0.75rem;
        }
        
        .options-container {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }
        
        .option-item {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
        }
        
        .option-text {
            max-width: 150px;
        }
    }
    
    /* Loading Animation */
    .loading-spinner {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* Enhanced Difficulty Analysis Animations */
    .difficulty-card {
        position: relative;
        overflow: hidden;
    }
    
    .difficulty-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.6s;
    }
    
    .difficulty-card:hover::before {
        left: 100%;
    }
    
    .difficulty-level-dots {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .difficulty-level-dots .dot {
        animation: scaleIn 0.4s ease-out;
        animation-fill-mode: both;
    }
    
    .difficulty-level-dots .dot:nth-child(1) { animation-delay: 0.1s; }
    .difficulty-level-dots .dot:nth-child(2) { animation-delay: 0.2s; }
    .difficulty-level-dots .dot:nth-child(3) { animation-delay: 0.3s; }
    .difficulty-level-dots .dot:nth-child(4) { animation-delay: 0.4s; }
    .difficulty-level-dots .dot:nth-child(5) { animation-delay: 0.5s; }
    
    .progress-bar-animated {
        position: relative;
        overflow: hidden;
    }
    
    .progress-bar-animated::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
        animation: shimmer 2s infinite;
    }
    
    .difficulty-badge {
        animation: bounceIn 0.8s ease-out;
    }
    
    .difficulty-title {
        animation: slideInLeft 0.6s ease-out;
    }
    
    .difficulty-explanation {
        animation: slideInUp 0.8s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.5);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    @keyframes shimmer {
        0% {
            left: -100%;
        }
        100% {
            left: 100%;
        }
    }
    
    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }
        50% {
            transform: scale(1.05);
        }
        70% {
            transform: scale(0.9);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .floating-elements {
        animation: float 6s ease-in-out infinite;
    }
    
    .floating-elements:nth-child(2) {
        animation-delay: -2s;
        animation-duration: 8s;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-20px) rotate(5deg);
        }
    }
    
    .gradient-text {
        background: linear-gradient(45deg, #3b82f6, #8b5cf6, #06b6d4);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: gradientShift 3s ease infinite;
    }
    
    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
    
    .pulse-glow {
        animation: pulseGlow 2s ease-in-out infinite alternate;
    }
    
    @keyframes pulseGlow {
        from {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }
        to {
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.6);
        }
    }

    /* Print styles */
    @media print {
        .action-buttons,
        .analytics-dashboard {
            display: none;
        }
        
        .question-card {
            box-shadow: none;
            border: 1px solid #e5e7eb;
        }
    }
</style>

<div class="question-container">
    <div class="question-card">
        <!-- Question Header -->
        <div class="question-header">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3 flex-1">
                    <div class="question-id-badge w-10 h-10 rounded-lg flex items-center justify-center bg-gray-100 text-gray-700 font-semibold text-sm">
                        #{{ $question->id }}
                    </div>
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                {{ $question->question_type === 'mcq' ? 'bg-blue-100 text-blue-800' : ($question->question_type === 'true_false' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                                {{ $question->question_type === 'mcq' ? 'MCQ' : ($question->question_type === 'true_false' ? 'T/F' : 'Descriptive') }}
                            </span>
                            <!-- Question Text moved here -->
                            <div class="question-text flex-1" title="{{ strip_tags($question->question_text) }}">
                                {{ strip_tags($question->question_text) }}
                            </div>
                        </div>
                        @if($question->difficulty_level)
                            <div class="mt-1 flex items-center gap-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $question->difficulty_color }}">
                                    {{ $question->difficulty_label }}
                                </span>
                                @if($question->has_enough_attempts_for_difficulty_calculation)
                                    <span class="text-xs text-gray-500" title="Based on {{ $question->difficulty_calculation_attempts }} attempts">
                                        ({{ $question->difficulty_correct_percentage }}% correct)
                                    </span>
                                @else
                                    <span class="text-xs text-gray-500" title="Based on {{ $question->difficulty_calculation_attempts }} attempts">
                                        ({{ $question->difficulty_calculation_attempts }} attempts)
                                    </span>
                                @endif
                                <!-- Breadcrumb moved here -->
                                <span class="text-xs text-gray-600">
                                    {{ $question->course->name ?? 'N/A' }} → {{ $question->subject->name ?? 'N/A' }} → {{ $question->topic->name ?? 'N/A' }}
                                </span>
                            </div>
                            <!-- Metadata moved here -->
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-600">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ $question->time_allocation ?? 'N/A' }} min</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $question->created_at->format('M d, Y') }}</span>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $question->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($question->status) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <!-- Options moved here -->
                    @if(in_array($question->question_type, ['mcq', 'true_false']))
                        <div class="options-container ml-4">
                            @if($question->option_a)
                                <div class="option-item {{ $question->correct_answer === 'a' ? 'correct' : '' }}" title="{{ $question->option_a }}">
                                    <div class="option-letter">A</div>
                                    <div class="option-text">{{ $question->option_a }}</div>
                                </div>
                            @endif
                            
                            @if($question->option_b)
                                <div class="option-item {{ $question->correct_answer === 'b' ? 'correct' : '' }}" title="{{ $question->option_b }}">
                                    <div class="option-letter">B</div>
                                    <div class="option-text">{{ $question->option_b }}</div>
                                </div>
                            @endif
                            
                            @if($question->option_c)
                                <div class="option-item {{ $question->correct_answer === 'c' ? 'correct' : '' }}" title="{{ $question->option_c }}">
                                    <div class="option-letter">C</div>
                                    <div class="option-text">{{ $question->option_c }}</div>
                                </div>
                            @endif
                            
                            @if($question->option_d)
                                <div class="option-item {{ $question->correct_answer === 'd' ? 'correct' : '' }}" title="{{ $question->option_d }}">
                                    <div class="option-letter">D</div>
                                    <div class="option-text">{{ $question->option_d }}</div>
                                </div>
                            @endif
                            
                            @if(!$question->option_a && !$question->option_b && !$question->option_c && !$question->option_d)
                                <div class="text-gray-500 text-xs italic">No options</div>
                            @endif
                        </div>
                    @endif
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col gap-2">
                    <div class="flex gap-2">
                        @if($question->question_type === 'mcq')
                            <a href="{{ route('partner.questions.mcq.edit', $question) }}" 
                               class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 group">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        @elseif($question->question_type === 'descriptive')
                            <a href="{{ route('partner.questions.descriptive.edit', $question) }}" 
                               class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 group">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        @elseif($question->question_type === 'true_false')
                            <a href="{{ route('partner.questions.tf.edit', $question) }}" 
                               class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 group">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('partner.questions.edit', $question) }}" 
                               class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 group">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                    <!-- Show Question Meta Data Button -->
                    <button onclick="toggleQuestionMetadata()" 
                            class="inline-flex items-center justify-center gap-1 px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Show Question Meta Data
                    </button>
                </div>
            </div>
            
            <!-- Marks -->
            @if($question->marks)
                <div class="flex items-center justify-end">
                    <div class="text-right">
                        <div class="text-xl font-bold text-gray-900">{{ $question->marks }}</div>
                        <div class="text-xs text-gray-500">Marks</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Question Content -->
        <div class="question-content">
            <!-- Question Image -->
            @if($question->image)
                <div class="image-container">
                    <img src="{{ Storage::url($question->image) }}" alt="Question Image" class="question-image">
                </div>
            @endif


            <!-- Descriptive Question Specific Fields -->
            @if($question->question_type === 'descriptive')
                @if($question->expected_answer_points)
                    <div class="explanation-section">
                        <div class="explanation-title">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Expected Answer Points
                        </div>
                        <div class="explanation-content">
                            {!! $question->expected_answer_points !!}
                        </div>
                    </div>
                @endif

                @if($question->sample_answer)
                    <div class="explanation-section">
                        <div class="explanation-title">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Sample Answer
                        </div>
                        <div class="explanation-content">
                            {!! $question->sample_answer !!}
                        </div>
                    </div>
                @endif

                @if($question->min_words || $question->max_words)
                    <div class="question-meta">
                        <div class="meta-grid">
                            @if($question->min_words)
                                <div class="meta-item">
                                    <div class="meta-label">Minimum Words</div>
                                    <div class="meta-value">{{ $question->min_words }}</div>
                                </div>
                            @endif
                            @if($question->max_words)
                                <div class="meta-item">
                                    <div class="meta-label">Maximum Words</div>
                                    <div class="meta-value">{{ $question->max_words }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if($question->key_concepts)
                    <div class="explanation-section">
                        <div class="explanation-title">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Key Concepts
                        </div>
                        <div class="explanation-content">
                            {!! $question->key_concepts !!}
                        </div>
                    </div>
                @endif
            @endif


            <!-- Question Metadata Section (Toggleable) -->
            <div id="question-metadata-section" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Question Metadata</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Basic Info -->
                    <div class="space-y-2">
                        <h4 class="text-xs font-medium text-gray-600 uppercase tracking-wide">Basic Information</h4>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Question ID:</span>
                                <span class="font-medium">#{{ $question->id }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Type:</span>
                                <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $question->question_type)) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Status:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $question->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($question->status) }}
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Created:</span>
                                <span class="font-medium">{{ $question->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Timing & Difficulty -->
                    <div class="space-y-2">
                        <h4 class="text-xs font-medium text-gray-600 uppercase tracking-wide">Timing & Difficulty</h4>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Time Allocation:</span>
                                <span class="font-medium">{{ $question->time_allocation ?? 'N/A' }} min</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Difficulty:</span>
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $question->difficulty_color }}">
                                        {{ $question->difficulty_label }}
                                    </span>
                                    @if($question->has_enough_attempts_for_difficulty_calculation)
                                        <span class="text-xs text-gray-500" title="Confidence: {{ round($question->difficulty_confidence * 100) }}%">
                                            ({{ $question->difficulty_correct_percentage }}% correct)
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-500" title="Based on {{ $question->difficulty_calculation_attempts }} attempts">
                                            ({{ $question->difficulty_calculation_attempts }} attempts)
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if($question->marks)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Marks:</span>
                                    <span class="font-medium">{{ $question->marks }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Course Information -->
                    <div class="space-y-2">
                        <h4 class="text-xs font-medium text-gray-600 uppercase tracking-wide">Course Information</h4>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Course:</span>
                                <span class="font-medium">{{ $question->course->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subject:</span>
                                <span class="font-medium">{{ $question->subject->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Topic:</span>
                                <span class="font-medium">{{ $question->topic->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            @if($question->tags && is_array($question->tags) && count($question->tags) > 0)
                <div class="tags-container">
                    @foreach($question->tags as $tag)
                        <span class="tag">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            <!-- Explanation -->
            @if($question->explanation)
                <div class="explanation-section">
                    <div class="explanation-title">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Explanation
                    </div>
                    <div class="explanation-content">
                        {!! $question->explanation !!}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Analytics Dashboard -->
    <div class="analytics-dashboard mt-8">
        <!-- Analytics Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Attempts</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $analytics['total_attempts'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Correct Answers</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $analytics['total_correct'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Incorrect Answers</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $analytics['total_incorrect'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Success Rate</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $analytics['correct_percentage'] ?? 0 }}%</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Difficulty Analysis Card -->
        <div class="bg-gradient-to-br from-slate-50 to-white rounded-lg shadow-sm p-6 mb-6 border border-slate-200 hover:shadow-md transition-all duration-300 hover:border-blue-300">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                Difficulty Analysis
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Difficulty Level -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-200 hover:shadow-md hover:border-blue-300 transition-all duration-300 hover:transform hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-gray-600 uppercase tracking-wide">Current Level</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $question->difficulty_color }}">
                                {{ $question->difficulty_label }}
                            </span>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 mb-2">{{ $question->difficulty_level }}/5</div>
                        <div class="flex space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="w-2 h-2 rounded-full {{ $i <= $question->difficulty_level ? 'bg-blue-500' : 'bg-gray-200' }}"></div>
                            @endfor
                        </div>
                    </div>

                    <!-- Confidence Score -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 border border-green-200 hover:shadow-md hover:border-green-300 transition-all duration-300 hover:transform hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-gray-600 uppercase tracking-wide">Confidence</span>
                            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">{{ round($question->difficulty_confidence * 100) }}%</span>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 mb-2">{{ round($question->difficulty_confidence * 100) }}%</div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full transition-all duration-300" style="width: {{ $question->difficulty_confidence * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Total Attempts -->
                    <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-lg p-4 border border-purple-200 hover:shadow-md hover:border-purple-300 transition-all duration-300 hover:transform hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-gray-600 uppercase tracking-wide">Total Attempts</span>
                            <span class="text-xs font-medium text-purple-600 bg-purple-100 px-2 py-1 rounded-full">for calculation</span>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 mb-2">{{ $question->difficulty_calculation_attempts }}</div>
                        <div class="flex items-center text-xs text-gray-600">
                            <svg class="w-3 h-3 mr-1 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span>Data Points</span>
                        </div>
                    </div>

                    <!-- Correct Percentage -->
                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-lg p-4 border border-orange-200 hover:shadow-md hover:border-orange-300 transition-all duration-300 hover:transform hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-gray-600 uppercase tracking-wide">Correct Rate</span>
                            <span class="text-xs font-medium text-orange-600 bg-orange-100 px-2 py-1 rounded-full">accuracy</span>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 mb-2">{{ $question->difficulty_correct_percentage }}%</div>
                        <div class="flex items-center text-xs text-gray-600">
                            <svg class="w-3 h-3 mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Success Rate</span>
                        </div>
                    </div>
                </div>

                <!-- Difficulty Explanation -->
                <div class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200 hover:shadow-md hover:border-blue-300 transition-all duration-300 hover:transform hover:-translate-y-1">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 mb-1">How is difficulty calculated?</h4>
                            <p class="text-xs text-gray-700 leading-relaxed">
                                @if($question->has_enough_attempts_for_difficulty_calculation)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">
                                        ✓ Reliable Data
                                    </span>
                                    This difficulty level is calculated based on student performance data from <strong>{{ $question->difficulty_calculation_attempts }} attempts</strong>. 
                                    The system analyzes the percentage of correct answers to determine if the question is Very Easy (90%+), Easy (75-89%), Medium (50-74%), Hard (25-49%), or Very Hard (<25%).
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mr-2">
                                        ⚠ Limited Data
                                    </span>
                                    This difficulty level is based on limited data (<strong>{{ $question->difficulty_calculation_attempts }} attempts</strong>). 
                                    For more accurate difficulty assessment, the question needs at least 10 attempts from students.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Analytics Tabs -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="tab-navigation">
                <nav class="flex space-x-2 px-6 py-2" aria-label="Tabs">
                    <button onclick="showTab('overview')" class="tab-button active">
                        Overview
                    </button>
                    <button onclick="showTab('students')" class="tab-button">
                        Student Performance
                    </button>
                    <button onclick="showTab('distribution')" class="tab-button">
                        Answer Distribution
                    </button>
                    <button onclick="showTab('timeline')" class="tab-button">
                        Performance Timeline
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="tab-content-container p-6">
                <!-- Overview Tab -->
                <div id="overview-tab" class="tab-content">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Performance Metrics -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Performance Metrics</h3>
                            
                            <div class="space-y-4">
                                <div class="metric-card flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Answer Rate</span>
                                    <span class="text-lg font-semibold text-gray-900">{{ $analytics['answer_rate'] ?? 0 }}%</span>
                                </div>
                                
                                <div class="metric-card flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Average Time Spent</span>
                                    <span class="text-lg font-semibold text-gray-900">
                                        @if($analytics['average_time_spent'])
                                            {{ floor($analytics['average_time_spent'] / 60) }}m {{ $analytics['average_time_spent'] % 60 }}s
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                                
                                <div class="metric-card flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Difficulty Level</span>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $question->difficulty_color }}">
                                            {{ $question->difficulty_label }}
                                        </span>
                                        @if($question->has_enough_attempts_for_difficulty_calculation)
                                            <span class="text-xs text-gray-500" title="Confidence: {{ round($question->difficulty_confidence * 100) }}%">
                                                ({{ $question->difficulty_correct_percentage }}% correct)
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-500" title="Based on {{ $question->difficulty_calculation_attempts }} attempts">
                                                ({{ $question->difficulty_calculation_attempts }} attempts)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="metric-card flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Skipped Questions</span>
                                    <span class="text-lg font-semibold text-gray-900">{{ $analytics['total_skipped'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                            
                            <div class="space-y-3 max-h-64 overflow-y-auto">
                                @forelse($recentAttempts as $attempt)
                                    <div class="activity-item flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-medium text-blue-600">
                                                    {{ substr($attempt->student->full_name ?? 'Unknown', 0, 2) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $attempt->student->full_name ?? 'Unknown Student' }}</p>
                                                <p class="text-xs text-gray-500">{{ $attempt->exam->title ?? 'Unknown Exam' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $attempt->is_correct ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $attempt->is_correct ? 'Correct' : 'Incorrect' }}
                                            </span>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $attempt->question_answered_at ? $attempt->question_answered_at->diffForHumans() : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-center py-4">No recent attempts found</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Student Performance Tab -->
                <div id="students-tab" class="tab-content hidden">
                    <div class="space-y-8">
                        <!-- Students who got it correct -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                                Students Who Answered Correctly ({{ $correctStudents->count() }})
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @forelse($correctStudents as $studentData)
                                    <div class="student-card">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-medium text-green-600">
                                                    {{ substr($studentData['student']->full_name ?? 'U', 0, 2) }}
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $studentData['student']->full_name ?? 'Unknown Student' }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $studentData['student']->phone ?? 'No phone' }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-1 text-xs text-gray-600">
                                            <div class="flex justify-between">
                                                <span>Attempts:</span>
                                                <span class="font-medium">{{ $studentData['attempts'] }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Last:</span>
                                                <span class="font-medium">
                                                    {{ $studentData['last_attempt'] ? $studentData['last_attempt']->format('M d') : 'N/A' }}
                                                </span>
                                            </div>
                                            @if($studentData['average_time'])
                                                <div class="flex justify-between">
                                                    <span>Time:</span>
                                                    <span class="font-medium">
                                                        {{ floor($studentData['average_time'] / 60) }}m {{ $studentData['average_time'] % 60 }}s
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if($studentData['exams']->count() > 0)
                                            <div class="mt-2">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($studentData['exams']->take(2) as $exam)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-green-100 text-green-800">
                                                            {{ Str::limit($exam, 15) }}
                                                        </span>
                                                    @endforeach
                                                    @if($studentData['exams']->count() > 2)
                                                        <span class="text-xs text-gray-500">+{{ $studentData['exams']->count() - 2 }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="col-span-full text-center py-8 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p>No students have answered this question correctly yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Students who got it incorrect -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Students Who Answered Incorrectly ({{ $incorrectStudents->count() }})
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @forelse($incorrectStudents as $studentData)
                                    <div class="student-card incorrect">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-medium text-red-600">
                                                    {{ substr($studentData['student']->full_name ?? 'U', 0, 2) }}
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $studentData['student']->full_name ?? 'Unknown Student' }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $studentData['student']->phone ?? 'No phone' }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-1 text-xs text-gray-600">
                                            <div class="flex justify-between">
                                                <span>Attempts:</span>
                                                <span class="font-medium">{{ $studentData['attempts'] }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Last:</span>
                                                <span class="font-medium">
                                                    {{ $studentData['last_attempt'] ? $studentData['last_attempt']->format('M d') : 'N/A' }}
                                                </span>
                                            </div>
                                            @if($studentData['average_time'])
                                                <div class="flex justify-between">
                                                    <span>Time:</span>
                                                    <span class="font-medium">
                                                        {{ floor($studentData['average_time'] / 60) }}m {{ $studentData['average_time'] % 60 }}s
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if(isset($studentData['common_wrong_answers']) && $studentData['common_wrong_answers']->count() > 0)
                                            <div class="mt-2">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($studentData['common_wrong_answers']->take(2) as $answer => $count)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-red-100 text-red-800">
                                                            {{ $answer }} ({{ $count }})
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if($studentData['exams']->count() > 0)
                                            <div class="mt-2">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($studentData['exams']->take(2) as $exam)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-red-100 text-red-800">
                                                            {{ Str::limit($exam, 15) }}
                                                        </span>
                                                    @endforeach
                                                    @if($studentData['exams']->count() > 2)
                                                        <span class="text-xs text-gray-500">+{{ $studentData['exams']->count() - 2 }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="col-span-full text-center py-8 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p>No students have answered this question incorrectly yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Answer Distribution Tab -->
                <div id="distribution-tab" class="tab-content hidden">
                    @if(count($answerDistribution) > 0)
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900">Answer Distribution</h3>
                            
                            <div class="space-y-3">
                                @foreach($answerDistribution as $answer => $count)
                                    @php
                                        $percentage = $analytics['total_answered'] > 0 ? round(($count / $analytics['total_answered']) * 100, 1) : 0;
                                        $isCorrect = $answer === $question->correct_answer;
                                    @endphp
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-2">
                                                <span class="w-6 h-6 bg-{{ $isCorrect ? 'green' : 'gray' }}-100 text-{{ $isCorrect ? 'green' : 'gray' }}-800 rounded flex items-center justify-center text-xs font-medium">
                                                    {{ strtoupper($answer) }}
                                                </span>
                                                <span class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $question->{'option_' . $answer} ?? 'Option ' . strtoupper($answer) }}
                                                </span>
                                                @if($isCorrect)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                        ✓
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <span class="text-lg font-bold text-gray-900">{{ $count }}</span>
                                                <span class="text-xs text-gray-500 ml-1">({{ $percentage }}%)</span>
                                            </div>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-{{ $isCorrect ? 'green' : 'blue' }}-500 h-1.5 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
        @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <p>No answer distribution data available for this question type</p>
                        </div>
                    @endif
                </div>

                <!-- Performance Timeline Tab -->
                <div id="timeline-tab" class="tab-content hidden">
                    @if($performanceOverTime->count() > 0)
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900">Performance Over Time</h3>
                            
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="space-y-4">
                                    @foreach($performanceOverTime as $monthData)
                                        @php
                                            $correctPercentage = $monthData->total_attempts > 0 ? round(($monthData->correct_attempts / $monthData->total_attempts) * 100, 1) : 0;
                                        @endphp
                                        <div class="flex items-center justify-between p-4 bg-white rounded-lg border">
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ \Carbon\Carbon::createFromFormat('Y-m', $monthData->month)->format('F Y') }}</h4>
                                                <p class="text-sm text-gray-500">{{ $monthData->total_attempts }} total attempts</p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-2xl font-bold text-gray-900">{{ $correctPercentage }}%</div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $monthData->correct_attempts }} correct, {{ $monthData->incorrect_attempts }} incorrect
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <p>No performance timeline data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between items-center mt-6">
        <a href="{{ route('partner.questions.all') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            Back to All Questions
            </a>
        
        <div class="flex gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
                Print
        </button>
        </div>
    </div>
</div>

<script>
// Tab functionality
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
        button.classList.add('border-transparent', 'text-gray-500');
        button.classList.remove('border-blue-500', 'text-blue-600');
    });
    
    // Show selected tab content
    const selectedTab = document.getElementById(tabName + '-tab');
    if (selectedTab) {
        selectedTab.classList.remove('hidden');
    }
    
    // Add active class to selected tab button
    const selectedButton = document.querySelector(`[onclick="showTab('${tabName}')"]`);
    if (selectedButton) {
        selectedButton.classList.add('active', 'border-blue-500', 'text-blue-600');
        selectedButton.classList.remove('border-transparent', 'text-gray-500');
    }
}

// Toggle Question Metadata
function toggleQuestionMetadata() {
    const metadataSection = document.getElementById('question-metadata-section');
    const button = document.querySelector('[onclick="toggleQuestionMetadata()"]');
    
    if (metadataSection && button) {
        if (metadataSection.classList.contains('hidden')) {
            metadataSection.classList.remove('hidden');
            button.innerHTML = `
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
                Hide Question Meta Data
            `;
        } else {
            metadataSection.classList.add('hidden');
            button.innerHTML = `
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Show Question Meta Data
            `;
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize first tab as active
    showTab('overview');
    
    // Add smooth scrolling for better UX
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add loading states to buttons
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function() {
            if (this.href && !this.href.includes('javascript:')) {
                this.classList.add('loading');
                const originalText = this.innerHTML;
                this.innerHTML = '<svg class="w-4 h-4 loading-spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...';
                
                // Reset after 3 seconds if still loading
                setTimeout(() => {
                    this.classList.remove('loading');
                    this.innerHTML = originalText;
                }, 3000);
            }
        });
    });
    
    // Add keyboard navigation for accessibility
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            // Close any open modals or go back
            if (window.history.length > 1) {
                window.history.back();
            }
        }
        
        // Tab navigation with arrow keys
        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            const activeTab = document.querySelector('.tab-button.active');
            if (activeTab) {
                const tabs = Array.from(document.querySelectorAll('.tab-button'));
                const currentIndex = tabs.indexOf(activeTab);
                let nextIndex;
                
                if (e.key === 'ArrowLeft') {
                    nextIndex = currentIndex > 0 ? currentIndex - 1 : tabs.length - 1;
                } else {
                    nextIndex = currentIndex < tabs.length - 1 ? currentIndex + 1 : 0;
                }
                
                const tabNames = ['overview', 'students', 'distribution', 'timeline'];
                if (tabNames[nextIndex]) {
                    showTab(tabNames[nextIndex]);
                }
            }
        }
    });
    
    // Add touch gestures for mobile
    let startY = 0;
    let startX = 0;
    
    document.addEventListener('touchstart', function(e) {
        startY = e.touches[0].clientY;
        startX = e.touches[0].clientX;
    });
    
    document.addEventListener('touchend', function(e) {
        const endY = e.changedTouches[0].clientY;
        const endX = e.changedTouches[0].clientX;
        const diffY = startY - endY;
        const diffX = startX - endX;
        
        // Swipe left to go back (if significant horizontal swipe)
        if (Math.abs(diffX) > Math.abs(diffY) && diffX > 50) {
            if (window.history.length > 1) {
                window.history.back();
            }
        }
    });
    
    // Add intersection observer for analytics cards animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe analytics cards for animation
    document.querySelectorAll('.analytics-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
    
    // Add search functionality for student lists
    function addStudentSearch() {
        const studentSections = document.querySelectorAll('#students-tab .space-y-8 > div');
        studentSections.forEach(section => {
            const heading = section.querySelector('h3');
            if (heading) {
                const searchInput = document.createElement('input');
                searchInput.type = 'text';
                searchInput.placeholder = 'Search students...';
                searchInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-lg mb-4 text-sm';
                
                const studentCards = section.querySelectorAll('.grid > div');
                
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    studentCards.forEach(card => {
                        const studentName = card.querySelector('p.text-sm.font-medium')?.textContent.toLowerCase() || '';
                        const studentPhone = card.querySelector('p.text-xs.text-gray-500')?.textContent.toLowerCase() || '';
                        
                        if (studentName.includes(searchTerm) || studentPhone.includes(searchTerm)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
                
                heading.parentNode.insertBefore(searchInput, heading.nextSibling);
            }
        });
    }
    
    // Initialize student search after a short delay to ensure DOM is ready
    setTimeout(addStudentSearch, 100);
});
</script>
@endsection
