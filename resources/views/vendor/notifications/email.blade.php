<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #007bff;
        }

        .content {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            text-align: left;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 30px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Xác thực tài khoản của bạn</h1>
        </div>
        <div class="content">
            <p>Chào {{ $notifiable->username }},</p>
            <p>Cảm ơn bạn đã đăng ký tài khoản với chúng tôi. Để xác thực tài khoản của bạn, vui lòng nhấn vào nút dưới
                đây:</p>
            <a style="color:white" href="{{ $verificationUrl }}" class="button">Xác nhận tài khoản</a>
            <p>Nếu bạn không yêu cầu tạo tài khoản, bạn có thể bỏ qua email này.</p>
        </div>
        <div class="footer">
            <p>Trân trọng,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>
