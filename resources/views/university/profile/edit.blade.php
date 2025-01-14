@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $config['profile']['index']['title'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">{{ $config['profile']['create']['title'] }}</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('university.profile.update') }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                <div class="row">
                                    <!-- Cột bên trái -->
                                    <div class="col-md-4 left-column">
                                        <h4 class="fw-semibold mb-3">Thông tin trường học <span
                                                class="text-danger">(*)</span></h4>
                                        <p>Điền đầy đủ thông tin dưới đây để cập nhật thông tin trường học vào hệ thống.</p>

                                        <h4 class="fw-semibold mb-3" style="margin-top: 75%;">Cập nhật thông tin trường học
                                            <span class="text-danger">(*)</span>
                                        </h4>
                                        <p>Vui lòng cập nhật các thông tin quan trọng của trường học để hệ thống có thể lưu
                                            trữ chính xác.</p>
                                    </div>

                                    <!-- Cột bên phải (Form nhập liệu) -->
                                    <div class="col-md-8 right-column">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tên trường <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ old('name', $university->name ?? '') }}"
                                                        placeholder="Nhập tên trường"
                                                        {{ isset($university->name) ? 'disabled' : '' }}>
                                                    @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="email" class="form-control" name="email"
                                                        value="{{ old('email', $university->email ?? '') }}"
                                                        placeholder="Nhập email"
                                                        {{ isset($university->email) ? 'disabled' : '' }}>
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Số điện thoại <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" name="phone" class="form-control"
                                                        value="{{ old('phone', $university->phone ?? '') }}"
                                                        placeholder="Nhập số điện thoại"
                                                        {{ isset($university->phone) ? 'disabled' : '' }}>

                                                    @error('phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Chuyên ngành <span
                                                            class="text-danger">(*)</span></label>
                                                    <select class="form-control" id="choices-multiple-remove-button"
                                                        name="majors[]" multiple>
                                                        @foreach ($majors as $item)
                                                            <option value="{{ $item->id }}"
                                                                @foreach ($major as $value)
                                                        {{ $value->id == $item->id ? 'selected' : '' }} @endforeach>
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('majors')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Hình ảnh</label>
                                                    <div class="d-flex">
                                                        @if (!empty($university->logo) && filter_var($university->logo, FILTER_VALIDATE_URL))
                                                            <img id="avatar-preview" src="{{ $university->logo }}"
                                                                width="38px" alt="Avatar" class="box-image">
                                                        @elseif (!empty($university->logo) && Storage::exists($university->logo))
                                                            <img id="avatar-preview"
                                                                src="{{ Storage::url($university->logo) }}" width="38px"
                                                                alt="Avatar" class="box-image">
                                                        @else
                                                            <img src="https://placehold.co/50" width="38px"
                                                                alt="Default Avatar" class="box-image">
                                                        @endif
                                                        <input type="file" name="logo" class="form-control"
                                                            id="avatar-input">
                                                    </div>

                                                    @error('logo')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Website </label>
                                                    <input type="text" name="url" class="form-control"
                                                        value="{{ old('url', $university->url ?? '') }}"
                                                        placeholder="Nhập đường liên kết">
                                                    @error('url')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Giới thiệu </label>
                                                    <input type="text" name="introduce"
                                                        value="{{ old('introduce', $university->introduce ?? '') }}"
                                                        class="form-control" placeholder="Nhập giới thiệu">
                                                    @error('introduce')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Địa chỉ <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" name="address" class="form-control"
                                                        value="{{ old('address', $university->address ?? '') }}"
                                                        placeholder="Nhập địa chỉ">
                                                    @error('address')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <label class="form-label">Mô tả</label>
                                                    <textarea name="description" id="editor1">{{ old('description', $university->description ?? '') }}</textarea>
                                                </div><!-- end card -->
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start gap-3 mt-4">
                                            <a href="{{ route('university.index') }}">
                                                <button type="button" class="btn btn-light btn-label">
                                                    <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                    Trở về
                                                </button>
                                            </a>
                                            <button type="submit" class="btn btn-success btn-label right ms-auto">
                                                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Cập
                                                nhật
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div>
        </div>
    </div>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor1'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        document.getElementById("avatar-input").addEventListener("change", function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("avatar-preview").src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectElement = document.getElementById("choices-multiple-remove-button");
            const choices = new Choices(selectElement, {
                removeItemButton: true,
                searchEnabled: true,
                placeholder: true,
                placeholderValue: "Chọn các ngành",
                shouldSort: false
            });
        });
    </script>
@endsection
