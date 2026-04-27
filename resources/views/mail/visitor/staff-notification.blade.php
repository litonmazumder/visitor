<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Visitor Registration</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md mt-10">
        <div class="mt-6">
            <p class="text-lg font-semibold">Dear {{$staffName}},</p>
            <p class="mt-4">We wanted to inform you that a new visitor has arrived and completed registration at our office. Please find their details below:</p>
            <div class="mt-4">
                <ul class="list-disc pl-5">
                    <li><strong>Visitor Name:</strong> {{ $visitorName }}</li>
                    <li><strong>Contact Number:</strong> <a href="tel:{{ $visitorMobile }}">{{ $visitorMobile }}</a></li>
                    <li><strong>Company/Organization:</strong> {{ $visitorCompany }}</li>
                    <li><strong>Purpose of Visit:</strong> {{ $visitPurpose }}</li>
                    <li><strong>Arrival Date & Time:</strong> {{ $visitEntryTime }}</li>
                </ul>
            </div>
            <p class="mt-6">Thank you.</p>
            <p class="mt-2 text-gray-600 text-sm">This is a system-generated e-mail. Please do not reply to the sender of this e-mail.</p>
        </div>
    </div>
</body>
</html>
