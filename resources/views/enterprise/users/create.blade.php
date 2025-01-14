@extends('admin.layouts.master')

@section('css')
    <!-- Filepond css -->
    <link rel="stylesheet" href="{{ asset('theme/admin/html/master/assets/libs/filepond/filepond.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="d-none">
        <div class="dropzone">
        </div>
        <ul class="list-unstyled mb-0" id="dropzone-preview">
            <li class="mt-2" id="dropzone-preview-list">

            </li>
        </ul>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ config('admin.enterprise.users.title') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="javascript: void(0);">{{ config('admin.enterprise.users.title') }}</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{ config('admin.enterprise.users.create .title') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            {{-- <div class="row">
                <div class="row col-sm-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="font-weight-bolder">{{ config('admin.enterprise.users.create .import.title') }}
                                </h3>
                            </div><!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end col -->
                </div>

                <div class="row col-sm-8">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalFullscreenSm"><i
                                        class="{{ config('admin.enterprise.users.create .import.icon') }}"></i>
                                    {{ config('admin.enterprise.users.create .import.button') }}</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div> --}}
            <form class="mb-3" action="{{ route('enterprise.users.store') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Cột bên trái -->
                    <div class="col-md-4 left-column">
                        <h4 class="fw-semibold mb-3">Thông tin nhân viên <span class="text-danger">(*)</span>
                        </h4>
                        <p>Điền đầy đủ thông tin dưới đây để thêm mới nhân viên vào hệ thống.</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModalFullscreenSm"><i
                                class="{{ config('admin.enterprise.users.create .import.icon') }}"></i>
                            {{ config('admin.enterprise.users.create .import.button') }}</button>
                    </div>

                    <!-- Cột bên phải (Form nhập liệu) -->
                    <div class="col-md-8 right-column">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Họ và tên <span class="text-danger">(*)</span></label>
                                    <input type="text"
                                        class="form-control
                                        @error('username')
                                        is-invalid
                                        @enderror"
                                        name="username" value="{{ old('username') }}" placeholder="Nhập họ và tên">
                                    @error('username')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">(*)</span></label>
                                    <input type="email"
                                        class="form-control 
                                        @error('email')
                                            is-invalid
                                        @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="Nhập email">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại <span class="text-danger">(*)</span></label>
                                    <input type="text" name="phone" style="padding-right: 55px"
                                        class="form-control 
                                    @error('phone')
                                        is-invalid
                                    @enderror"
                                        value="{{ old('phone') }}" placeholder="Nhập số điện thoại">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu <span class="text-danger">(*)</span></label>

                                    <div class="position-relative auth-pass-inputgroup">
                                        <input type="password" name="password" style="padding-right: 55px"
                                            class=" password password-input form-control @error('password')
                                                            is-invalid
                                                        @enderror"
                                            placeholder="Nhập mật khẩu">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <button style="right: 10px;"
                                            class="password_show btn btn-link position-absolute top-0 text-decoration-none text-muted password-addon material-shadow-none"
                                            type="button"><i class="ri-eye-fill align-middle "></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nhập lại mật khẩu <span class="text-danger">(*)</span></label>
                                    <div class="position-relative auth-pass-inputgroup">
                                        <input type="password" name="re_password"
                                            class=" password password-input form-control @error('re_password')
                                        is-invalid
                                        @enderror"
                                            placeholder="Nhập mật khẩu">
                                        @error('re_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <button style="right: 10px;"
                                            class="password_show btn btn-link position-absolute top-0 text-decoration-none text-muted password-addon material-shadow-none"
                                            type="button"><i class="ri-eye-fill align-middle "></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="fw-semibold">Trạng thái <span class="text-danger">(*)</span>
                                    </h6>
                                    <div class="d-flex">
                                        <div class="form-check form-radio-outline form-radio-success mt-2">
                                            <input class="form-check-input" type="radio" name="is_active"
                                                id="activeStatus" value="{{ IS_ACTIVE }}" checked>
                                            <label class="form-check-label" for="activeStatus">
                                                Hoạt động
                                            </label>
                                        </div>
                                        <div class="form-check form-radio-outline form-radio-danger mt-2 ms-3">
                                            <input class="form-check-input" type="radio" name="is_active"
                                                id="inactiveStatus" value="{{ UN_ACTIVE }}">
                                            <label class="form-check-label" for="inactiveStatus">
                                                Không hoạt động
                                            </label>
                                        </div>
                                    </div>
                                    @error('is_active')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3 mt-4">
                            <a href="{{ route('enterprise.users.index') }}">
                                <button type="button" class="btn btn-light btn-label">
                                    <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                    Trở về
                                </button>
                            </a>
                            <button type="submit" class="btn btn-success btn-label right ms-auto">
                                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Thêm
                                mới
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalFullscreenSm" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalFullscreenSmLabel" aria-hidden="true">
        <div class="modal-dialog .modal-dialog-scrollable modal-dialog-centered modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalFullscreenSmLabel">
                        {{ config('admin.enterprise.users.create .import.description') }}</h5>
                    <a href="{{ asset('assets/enterprise/example.xlsx') }}" download=""><button type="button"
                            class="btn btn-secondary">{{ config('admin.enterprise.users.create .import.file-example') }}
                        </button>
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" class="filepond filepond-input-multiple" multiple name="filepond"
                        data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3">
                    <h5>{{ config('admin.enterprise.users.create .import.data-title') }}</h5>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <div class="error_import">
                        </div>
                        <table class="table align-middle overflow-auto " style="max-height: 50%" id="customerTable">
                            <thead class="table-light" style="position: sticky; top: 0; z-index: 1;">
                                <tr>
                                    {{-- <th scope="col" style="width: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th> --}}
                                    <th class="sort" data-sort="email">Email</th>
                                    <th class="sort" data-sort="username">Username</th>
                                    <th class="sort" data-sort="phone">Phone</th>
                                    <th>Password</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all data_xlsx">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium material-shadow-none"
                        data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                        {{ config('admin.enterprise.users.cancel') }}</a>
                    <button type="button"
                        class="btn btn-primary btn_import">{{ config('admin.enterprise.users.create .import.button') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- listjs init -->
    <script src="{{ asset('theme/admin/html/master/assets/js/pages/listjs.init.js') }}"></script>
    <!-- dropzone min -->
    <script src="{{ asset('theme/admin/html/master/assets/libs/dropzone/dropzone-min.js') }}"></script>
    <!-- filepond js -->
    <script src="{{ asset('theme/admin/html/master/assets/libs/filepond/filepond.min.js') }}"></script>
    <script
        src="{{ asset('theme/admin/html/master/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script
        src="{{ asset('theme/admin/html/master/assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('theme/admin/html/master/assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script
        src="{{ asset('theme/admin/html/master/assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}">
    </script>
    <script src="{{ asset('theme/admin/html/master/assets/js/pages/form-file-upload.init.js') }}"></script>

    <!-- use version 0.20.3 -->
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.password_show').on('click', function() {
                let input = $('.password-input'); // Chọn input mật khẩu

                let type = input.attr('type') === 'password' ? 'text' : 'password'; // Xác định type mới

                input.attr('type', type); // Thay đổi type
            });

            $('.re_password').keyup(function(e) {
                let re_password = $(this).val();

                const password = $('.password').val()

                if (re_password !== '' && re_password !== password) {
                    $('.re_password').addClass('is-invalid');
                    $('.re_pass_feedback').text('Password không giống nhau');
                } else {
                    $('.re_password').removeClass('is-invalid');
                    $('.re_pass_feedback').text('');
                }
            });

            const passwordInput = $('.password');
            const rePasswordInput = $('.re_password');

            // Disable re_password mặc định
            rePasswordInput.prop('disabled', true);

            // Lắng nghe sự kiện input của password
            passwordInput.on('input', function() {
                const passwordValue = $(this).val();

                if (passwordValue.trim() !== '') {
                    // Nếu password có giá trị, kích hoạt re_password
                    rePasswordInput.prop('disabled', false);
                } else {
                    // Nếu password trống, vô hiệu hóa re_password và xóa giá trị của nó
                    rePasswordInput.prop('disabled', true).val('');
                    rePasswordInput.removeClass('is-invalid');
                    rePasswordInput.siblings('.re_pass_feedback').text('');
                }
            });

            const role_required = $('.role_required')
            const role_id = $('.role_id')
            $(role_id).change(function(e) {
                const role_id = $(this).val()

                if (role_id !== '') {
                    role_required.addClass('d-none')
                } else {
                    role_required.removeClass('d-none')
                }
            });

            if (role_id.val() !== '') {
                role_required.addClass('d-none')
            } else {
                role_required.removeClass('d-none')
            }

            const pond = FilePond.create(document.querySelector('.filepond'), {
                acceptedFileTypes: ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
            });
            // Lắng nghe sự kiện khi file được thêm vào FilePond
            pond.on('addfile', (error, file) => {
                if (!error) {
                    // Đọc file khi đã được tải lên FilePond
                    console.log(file);

                    read_xlsx(file.file);
                }
            });

            pond.on('removefile', () => {
                handleClose()
            })

            let jsonData = null

            const read_xlsx = (file) => {
                if (file) {

                    const reader = new FileReader();

                    reader.readAsArrayBuffer(file);

                    reader.onload = function(e) {
                        const data = new Uint8Array(e.target.result);
                        const workbook = XLSX.read(data, {
                            type: 'array'
                        });

                        // Giả sử bạn muốn lấy sheet đầu tiên
                        const sheetName = workbook.SheetNames[0];
                        const sheet = workbook.Sheets[sheetName];

                        // Chuyển sheet thành dữ liệu JSON
                        jsonData = XLSX.utils.sheet_to_json(sheet);

                        // Xử lý dữ liệu JSON (ví dụ hiển thị lên màn hình)
                        console.log(jsonData);
                        show_data_xlsx(jsonData)
                    };
                }
            }

            const show_data_xlsx = (json_data) => {
                let data = '';

                json_data.forEach(item => {
                    data += /*html*/
                        `<tr>
                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                    class="fw-medium link-primary">#VZ2101</a></td>
                            <td class="email">${item.email}</td>
                            <td class="username">${item.username}</td>
                            <td class="phone">${item.phone || ''}</td>
                            <td >${item.password}</td>
                        </tr>`
                });

                console.log(data);

                $('.data_xlsx').html(data);
            }

            $('.btn_import').on('click', function() {

                console.log(jsonData);

                if (jsonData) {
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': `{{ csrf_token() }}`,
                            'Content-Type': 'application/json'
                        },
                        url: "{{ route('enterprise.users.import') }}",
                        data: JSON.stringify({
                            data: jsonData
                        }),
                        dataType: "json",
                        success: function(res) {
                            if (res.data) {
                                location.href = "{{ route('enterprise.users.index') }}";
                            }

                            if (res.messages) {
                                let messages = ''
                                $.each(res.messages, function(indexInArray, message) {
                                    messages += `<li>${message}</li>`
                                });
                                $('.error_import').html(messages);
                                $('.error_import').addClass('alert alert-danger');
                            }
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 422) { // Mã lỗi validate 422
                                var errors = xhr.responseJSON.errors;
                                let messages = ''
                                // Hiển thị lỗi cho từng email
                                $.each(errors, function(field, message) {
                                    messages += `<li>${message}</li>`
                                });
                                $('.error_import').html(messages);
                                $('.error_import').addClass('alert alert-danger');
                            }
                        }
                    });
                }
            });

            exampleModalFullscreenSm.addEventListener('hidden.bs.modal', event => {
                handleClose()
            })

            const handleClose = () => {
                jsonData = null
                $('.error_import').empty();
                $('.data_xlsx').empty();
                $('.error_import').removeClass('alert alert-danger')
                pond.removeFiles();
            }

        });

        // document.querySelector('.password-input').addEventListener('keypress', function(e) {
        //     let char = String.fromCharCode(e.which || e.keyCode);
        //     if (!/^[a-zA-Z0-9]$/.test(char)) {
        //         e.preventDefault(); // Ngăn chặn ký tự không hợp lệ
        //     }
        // });
    </script>
@endsection
