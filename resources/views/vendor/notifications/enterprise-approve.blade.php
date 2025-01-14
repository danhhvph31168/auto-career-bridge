<h2>Xin chào {{ $enterprise->username }}!</h2>
@if ($enterprise->status === 1)
    <p>Tài khoản của bạn đã được phê duyệt thành công.</p>
    <p>Vui lòng <a href="{{ url('/login') }}">đăng nhập</a> để tiếp tục sử dụng dịch vụ.</p>
@else
    <p>Rất tiếc, tài khoản của bạn chưa được phê duyệt.</p>
    <p><strong>Lý do:</strong> {{ $reason }}</p>
    <p>Vui lòng kiểm tra lại thông tin</p>
@endif
<p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
<p>Trân trọng!</p>
