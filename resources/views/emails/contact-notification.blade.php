<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #16a34a, #3b82f6);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 0 0 8px 8px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            color: #16a34a;
            margin-bottom: 5px;
        }
        .field-value {
            background: white;
            padding: 10px;
            border-radius: 4px;
            border-left: 4px solid #16a34a;
        }
        .message-content {
            background: white;
            padding: 15px;
            border-radius: 4px;
            border-left: 4px solid #3b82f6;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Contact Message</h1>
        <p>You have received a new message through your website contact form.</p>
    </div>
    
    <div class="content">
        <div class="field">
            <div class="field-label">Name:</div>
            <div class="field-value">{{ $contactMessage->name }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Email:</div>
            <div class="field-value">{{ $contactMessage->email }}</div>
        </div>
        
        @if($contactMessage->phone)
        <div class="field">
            <div class="field-label">Phone:</div>
            <div class="field-value">{{ $contactMessage->phone }}</div>
        </div>
        @endif
        
        <div class="field">
            <div class="field-label">Subject:</div>
            <div class="field-value">{{ $contactMessage->subject }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Message:</div>
            <div class="message-content">{{ $contactMessage->message }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Submitted:</div>
            <div class="field-value">{{ $contactMessage->created_at ? $contactMessage->created_at->format('F j, Y \a\t g:i A') : now()->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>
</body>
</html>
