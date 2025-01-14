<!DOCTYPE html>
<html>
<head>
    <title>Đặt lại mật khẩu</title>
</head>
<body>
    <h1>Chào {{ $notifiable->username }},</h1>
    <p>Bạn nhận được email này vì chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>
    <p><a href="{{ $resetUrl }}">Nhấn vào đây để đặt lại mật khẩu</a></p>
    <p>Nếu bạn không yêu cầu thay đổi mật khẩu, không cần thực hiện thêm hành động nào.</p>
</body>
</html>
