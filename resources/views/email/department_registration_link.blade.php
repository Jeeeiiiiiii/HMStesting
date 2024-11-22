<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container {
            width: 100% !important;
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            font-size: 24px;
            color: #333333;
            margin-bottom: 10px;
        }
        .body-text {
            color: #555555;
            line-height: 1.6;
        }
        .footer-text {
            color: #555555;
            margin-top: 20px;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div class="container">
        <h1 class="header">Registration</h1>
        <p class="body-text">Complete your Department registration here:</p>
        <a href="{{ route('department_final_register', $token) }}" 
           style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #ffffff; background-color: #007bff; text-decoration: none; border-radius: 4px; margin-top: 10px;">
           Register
        </a>
        <p class="footer-text">If you did not request this registration, please ignore this email.</p>
    </div>
</body>
</html>
