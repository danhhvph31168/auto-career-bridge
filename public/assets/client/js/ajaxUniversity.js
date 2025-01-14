$(document).ready(function() {
    function loadUniversities(
        majorId,
        pageUrl = '/universities',
        perPage = $('#perPage').val(),
        searchName = $('#search_name').val(),
        province = $('#province').val(),
    ) {
        $.ajax({
            url: pageUrl,
            method: 'GET',
            data: {
                major_id: majorId,
                per_page: perPage,
                search_name: searchName,
                province: province,
                res: 'json',
            },
            success: function(response) {
                $('#list-university').html(response.html);
                $('#pagination').html(response.pagination);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    }

    $('#major_university').change(function() {
        const majorId = $(this).val();
        loadUniversities(majorId);
    });

    $('#province').change(function() {
        const selectedValue = $(this).val();
        const majorId = $('#major_university').val();

        if (selectedValue.includes('Thành phố')) {
            var province = selectedValue.replace('Thành phố ', '')
        } else {
            var province = selectedValue.replace('Tỉnh ', '')
        }

        loadUniversities(majorId, undefined, undefined, undefined, province);
    });

    $('#perPage').change(function() {
        const perPage = $(this).val();
        const majorId = $('#major_university').val();
        loadUniversities(majorId, undefined, perPage);
    });

    $(document).on('click', '.pagination-area a', function(e) {
        e.preventDefault();
        const pageUrl = $(this).attr('href');
        const majorId = $('#major_university').val();
        loadUniversities(majorId, pageUrl);
    });

    $('#search_name').on('input', function() {
        const searchName = $(this).val();
        const majorId = $('#major_university').val();
        loadUniversities(majorId, undefined, undefined, searchName);
    });

    $('.shorting-menu .filter').on('click', function() {
        var filterType = $(this).data('filter');

        if (filterType === 'all') {
            $('.mix').show();
        } else {
            $('.mix').each(function() {
                if ($(this).hasClass(filterType)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });
});

const host = "https://provinces.open-api.vn/api/";
var callAPI = (api) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data, "province");
        });
}
callAPI('https://provinces.open-api.vn/api/?depth=1');

var renderData = (array, select) => {
    let row = ' <option disable value="">Thành phố</option>';
    array.forEach(element => {
        row += `<option value="${element.name}">${element.name}</option>`
    });
    document.querySelector("#" + select).innerHTML = row
}
