<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h2>Xin chào {{ $user->username ?? $user->name }}</h2>
        @if ($user->deleted_at)
            <p>Tài khoản của bạn đã bị xóa</p>
        @else
            @if ($user->status == 1)
                <p>Tài khoản của bạn đã được phê duyệt thành công!</p>
            @elseif ($user->status == 2)
                <p>Tài khoản của bạn chưa được phê duyệt</p>
                <p>Lý do: <span>{{ $reason }}</span></p>
            @endif
        @endif


        <p>Cảm ơn bạn đã sử dụng hệ thống của chúng tôi.</p>
        <a href="{{ url('/') }}">Truy cập hệ thống</a>
    </div>
</body>

</html>
