$(document).ready(function () {

    $('.per_page').change(function (e) {
        const perPage = $(this).val();
        const queryParams = new URLSearchParams(window.location.search);

        queryParams.set('perPage', perPage);
        queryParams.delete('page')

        const newUrl = window.location.pathname + '?' + queryParams.toString();

        window.location.href = newUrl;
    });

    var sortDirection = {}; // Lưu trữ hướng sắp xếp cho từng cột (true = giảm dần, false = tăng dần)

    $(document).on('click', '.sort', function () {
        var column = $(this).data('sort');
        var rows = $('#customerTable tbody tr').get(); // Lấy tất cả các hàng trong bảng
        var isNumberColumn = column === 'stt' || column === 'phone'; // Các cột là số
        var isDateColumn = column === 'created_at' || column === 'start_date' || column === 'end_date'; // Cột ngày tháng (date)
        var isActive = column === 'is_active';
        var status = column === 'status';

        if (sortDirection[column] === undefined) {
            sortDirection[column] = true;
        }

        rows.sort(function (a, b) {
            var cellA = $(a).find('.' + column).text().trim();
            var cellB = $(b).find('.' + column).text().trim();

            // Xử lý sắp xếp theo số
            if (isNumberColumn) {
                var numA = parseFloat(cellA.replace(/[^\d.-]/g, '')); // Chuyển chuỗi thành số
                var numB = parseFloat(cellB.replace(/[^\d.-]/g, ''));
                return sortDirection[column] ? numB - numA : numA - numB; // Nếu true thì sắp xếp giảm dần
            }

            if (isDateColumn) {
                var parseDate = function (dateString) {
                    var parts = dateString.split('/');
                    return new Date(parts[2], parts[1] - 1, parts[0]); // Giả định định dạng dd/mm/yyyy
                };
                var dateA = parseDate(cellA);
                var dateB = parseDate(cellB);
                return sortDirection[column] ? dateB - dateA : dateA - dateB;
            }

            if (column === 'status') {
                // Gán giá trị cho từng trạng thái
                const statusValue = {
                    'Từ chối': 0,
                    'Chờ duyệt': 1,
                    'Đã duyệt': 2
                };

                // Lấy giá trị của trạng thái từ bảng
                var valueA = statusValue[cellA] || 0; // Mặc định 0 nếu không khớp
                var valueB = statusValue[cellB] || 0;

                // Sắp xếp tăng dần hoặc giảm dần
                return sortDirection[column] ? valueB - valueA : valueA - valueB;
            }

            if (isActive) {
                // Lấy trạng thái của checkbox (true nếu được chọn, false nếu không)
                var valueA = $(a).find('.' + column + ' input[type="checkbox"]').is(':checked') ? 1 : 0;
                var valueB = $(b).find('.' + column + ' input[type="checkbox"]').is(':checked') ? 1 : 0;

                // Sắp xếp giảm dần hoặc tăng dần
                return sortDirection[column] ? valueB - valueA : valueA - valueB;
            }

            // Xử lý sắp xếp theo chuỗi
            return sortDirection[column] ? cellB.localeCompare(cellA) : cellA.localeCompare(cellB); // Nếu true thì sắp xếp giảm dần
        });

        // Lưu hướng sắp xếp mới sau khi click
        sortDirection[column] = !sortDirection[column]; // Đảo ngược hướng sắp xếp

        // Đưa các dòng đã sắp xếp lại vào bảng
        $.each(rows, function (index, row) {
            $('#customerTable tbody').append(row);
        });

        $(this).toggleClass("select_sort");

    });

});