let isListenerAdded = false; // Biến để theo dõi listener

function showSweetAlert(id, idUniversity) {
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa không?',
        text: 'Dữ liệu này sẽ không thể phục hồi!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            // Hiển thị loading sau khi người dùng nhấn "Xóa"
            Swal.fire({
                title: 'Đang xử lý...',
                text: 'Vui lòng đợi...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Gọi Livewire để xóa tài khoản
            Livewire.dispatch('deleteAccount', {
                id: id,
                idUniversity: idUniversity
            });

            // Lắng nghe sự kiện "accountDeleted" chỉ khi chưa lắng nghe
            if (!isListenerAdded) {
                isListenerAdded = true;

                Livewire.on('accountDeleted', (data) => {
                    Swal.close(); // Đóng loading

                    // Kiểm tra kết quả và hiển thị thông báo
                    if (data[0]) {
                        flasher.success('Xóa tài khoản thành công');
                    } else {
                        flasher.error('Xóa tài khoản thất bại');
                    }

                    // Hủy bỏ listener sau khi xử lý xong
                    isListenerAdded = false;
                });
            }
        }
    });
}