function confirmDelete(id) {
    console.log(id);

    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa không?',
        // text: 'Dữ liệu này sẽ không thể phục hồi!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Gửi form xóa nếu người dùng xác nhận
            document.getElementById('deleteForm-' + id).submit();
        }
    });
}

(function ($) {
    "use strict";
    var statusToggle = {};
    var _token = $('meta[name="csrf-token"]').attr('content');

    statusToggle.changeStatus = () => {
        $(document).on('change', '.form-check-input', function (e) {
            let _this = $(this);
            let currentValue = _this.val();
            let option = {
                'value': currentValue,
                'modelId': _this.attr('data-modelId'),
                'model': _this.attr('data-model'),
                'field': _this.attr('data-field'),
                '_token': _token,
            }

            console.log(option);

            $.ajax({
                url: '/changeStatus',
                type: 'POST',
                data: option,
                dataType: 'json',
                success: function (res) {
                    let inputValue = (currentValue == '1') ? '0' : '1';

                    if (res.flag == true) {
                        _this.val(inputValue);
                        flasher.success('Trạng thái đã thay đổi thành công.');
                    } else {
                        flasher.error('Không thể thay đổi trạng thái. Vui lòng thử lại.');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('Lỗi: ' + textStatus + ' ' + errorThrown);
                }
            });

            e.preventDefault();
        });
    }
    statusToggle.checkAll = () => {
        if ($('#checkAll').length) {
            $(document).on('click', '#checkAll', function () {
                console.log(134);

                let isChecked = $(this).prop('checked');
                $('.checkBoxItem').prop('checked', isChecked);
            })
        }
    }

    $(document).ready(function () {
        statusToggle.changeStatus();
        statusToggle.checkAll();
    });
})(jQuery);
