@extends('admin.layouts.master')

@section('content')
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
                                    {{ config('admin.enterprise.users.edit.title') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <!-- end page title -->
                <div class="row col-sm-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="font-weight-bolder">{{ config('admin.enterprise.users.create .description') }}
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

                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="{{ route('enterprise.users.update', $user) }}" class="tablelist-form "
                                            autocomplete="off" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="row gy-4">
                                                <div class="col-xxl-3 col-md-6">
                                                    <div class="form-floating">
                                                        <input name="username" value="{{ $user->username }}" type="text"
                                                            class="form-control 
                                                    @error('username')
                                                        is-invalid
                                                    @enderror"
                                                            placeholder="Enter your firstname">
                                                        <label for="firstnamefloatingInput">UserName
                                                            <span class="required text-danger">(*)</span>:</label>
                                                        @error('username')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-xxl-3 col-md-6">
                                                    <div class="form-floating">
                                                        <input name="phone" value="{{ $user->phone }}" type="text"
                                                            class="form-control @error('phone')
                                                        is-invalid
                                                    @enderror"
                                                            placeholder="Enter your firstname">
                                                        <label for="firstnamefloatingInput">Phone:</label>
                                                        @error('phone')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-xxl-3 col-md-6">
                                                    <div class="form-floating">
                                                        <input name="email" value="{{ $user->email }}" type="text"
                                                            class="form-control @error('email')
                                                        is-invalid
                                                    @enderror"
                                                            placeholder="Enter your firstname">
                                                        <label for="firstnamefloatingInput">Email <span
                                                                class="required text-danger">(*)</span>:</label>
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-xxl-3 col-md-6 position-relative">
                                                    <span class="required text-danger position-absolute role_required"
                                                        style="left: 105px; top: 14px">(*)</span>
                                                    <select name="role_id" style="padding-bottom: 20px"
                                                        class="form-select form-select-lg @error('role_id')
                                                        is-invalid
                                                    @enderror role_id"
                                                        aria-label=".form-select-lg example">

                                                        <option value="" selected>Chọn role </option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role['id'] }}"
                                                                {{ $user->role_id == $role['id'] ? 'selected' : '' }}>
                                                                {{ $role['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('role_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-xxl-3 col-md-6">
                                                    <div class="form-floating">
                                                        <input name="password" type="password"
                                                            class="form-control @error('password')
                                                        is-invalid
                                                    @enderror form-control pe-5 password password-input"
                                                            placeholder="Enter your firstname"
                                                            autocomplete="current-password">
                                                        <label for="firstnamefloatingInput">Password <span
                                                                class="required text-danger">(*)</span>:</label>
                                                        @error('password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <button
                                                            class="password_show btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                                                            type="button"><i class="ri-eye-fill align-middle "></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-3 col-md-6">
                                                    <div class="form-floating">
                                                        <input name="re_password" type="password"
                                                            class="form-control @error('re_password')
                                                        is-invalid
                                                    @enderror password-input re_password"
                                                            placeholder="Enter your firstname">
                                                        <label for="firstnamefloatingInput">Confirm password <span
                                                                class="required text-danger">(*)</span>:</label>
                                                        <div class="invalid-feedback re_pass_feedback">
                                                            @error('re_password')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                        <button
                                                            class="password_show btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                                                            type="button"><i class="ri-eye-fill align-middle "></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-3 col-md-6 d-flex align-items-center">
                                                    <div class="form-check form-switch form-switch-success">
                                                        <input value="1" name="is_active"
                                                            class="form-check-input 
                                                            @error('is_active')
                                                        is-invalid
                                                    @enderror"
                                                            type="checkbox" role="switch" id="SwitchCheck3"
                                                            @checked($user->is_active)>
                                                        <label class="form-check-label" for="SwitchCheck3">Trạng thái tài
                                                            khoản</label>
                                                        @error('is_active')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer mt-3">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <a href="{{ route('enterprise.users.index') }}"><button
                                                            type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">{{ config('admin.enterprise.users.return') }}</button>
                                                    </a>
                                                    <button type="submit" class="btn btn-success"
                                                        id="add-btn">{{ config('admin.enterprise.users.edit.button') }}</button>
                                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
            </div> --}}
            <form class="mb-3" action="{{ route('enterprise.users.update', $user) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <!-- Cột bên trái -->
                    <div class="col-md-4 left-column">
                        <h4 class="fw-semibold mb-3">Thông tin nhân viên <span class="text-danger">(*)</span>
                        </h4>
                        <p>Điền đầy đủ thông tin dưới đây để cập nhật thông tin nhân viên.</p>
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
                                        name="username" value="{{ $user->username }}" placeholder="Nhập họ và tên">
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
                                        name="email" value="{{ $user->email }}" placeholder="Nhập email">
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
                                        value="{{ $user->phone }}" placeholder="Nhập số điện thoại">
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
                                                id="activeStatus" value="{{ IS_ACTIVE }}" @checked($user->is_active == IS_ACTIVE)>
                                            <label class="form-check-label" for="activeStatus">
                                                Hoạt động
                                            </label>
                                        </div>
                                        <div class="form-check form-radio-outline form-radio-danger mt-2 ms-3">
                                            <input class="form-check-input" type="radio" name="is_active"
                                                id="inactiveStatus" value="{{ UN_ACTIVE }}"
                                                @checked($user->is_active == UN_ACTIVE)>
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
                                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Cập nhật
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <!-- listjs init -->
    <script src="{{ asset('theme/admin/assets/js/pages/listjs.init.js') }}"></script>

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
                console.log(1);

                role_required.addClass('d-none')
            } else {
                console.log(2);
                role_required.removeClass('d-none')
            }
        });
    </script>
@endsection
