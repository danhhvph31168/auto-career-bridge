<h1>Xin chào {{ $university->name }} !</h1>

@if ($workshop->status === APPROVED)
    <p>Chúng tôi muốn thông báo rằng tin đăng: <strong>{{ $workshop->title }}</strong> của bạn đã được phê duyệt.
    @else
    <p>Rất tiếc, tin đăng <strong>{{ $workshop->title }}</strong> đã bị huỷ phê duyệt.</p>
    @if ($reason)
        <p><strong>Lý do:</strong> {{ $reason }}</p>
        Vui lòng kiểm tra lại thông tin
    @endif
@endif
<p>Truy cập trang quản lý để kiểm tra chi tiết.</p>
<p>Trân trọng</p>
