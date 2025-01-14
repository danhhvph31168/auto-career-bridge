<h1>Xin chào {{ $username }} !</h1>

@if ($job->status === APPROVED)
    <p>Chúng tôi muốn thông báo rằng công việc: <strong>{{ $job->title }}</strong> của bạn đã được phê duyệt.
    @else
    <p>Rất tiếc, công việc <strong>{{ $job->title }}</strong> đã bị huỷ phê duyệt.</p>
    @if ($reason)
        <p><strong>Lý do:</strong> {{ $reason }}</p>
        Vui lòng kiểm tra lại thông tin
    @endif
@endif
<p>Truy cập trang quản lý để kiểm tra chi tiết.</p>
<p>Trân trọng</p>
