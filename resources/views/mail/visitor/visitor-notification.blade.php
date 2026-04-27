<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Visitor Registration Confirmation</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            background-color: #f3f4f6;
            padding: 20px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <div class="text-center">
            <p class="mt-4 text-gray-600">Dear {{$visitorName}},</p>
        </div>
        <div class="mt-6">
            <p class="text-base text-gray-700">Thank you for registering in our system. We have successfully recorded your information.</p>
            <p class="mt-4 text-base text-gray-700">For your future visits, please use your registered mobile number <strong>{{$visitorMobile}}</strong> to check in quickly and easily.</p>
            <p class="mt-4 text-base text-gray-700">We look forward to welcoming you again soon.</p>
        </div>
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
