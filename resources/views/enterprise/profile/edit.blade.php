@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $config['profile']['title'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">{{ $config['profile']['create'] }}</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('enterprise.profile.update') }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                <div class="row">
                                    <div class="col-md-4 left-column">
                                        <h4 class="fw-semibold mb-3">Thông tin doanh nghiệp <span
                                                class="text-danger">(*)</span></h4>
                                        <p>Điền đầy đủ thông tin dưới đây để cập nhật thông tin doanh nghiệp vào hệ thống.
                                        </p>

                                        <h4 class="fw-semibold mb-3" style="margin-top: 75%;">Cập nhật thông tin doanh
                                            nghiệp <span class="text-danger">(*)</span></h4>
                                        <p>Vui lòng cập nhật các thông tin quan trọng của doanh nghiệp để hệ thống có thể
                                            lưu trữ chính xác.</p>
                                    </div>

                                    <div class="col-md-8 right-column">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tên doanh nghiệp <span
                                                            class="text-danger">(*)</span></label>
                                                    @if (!empty($enterprise->name) && $enterprise->is_verify)
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ $enterprise->name }}" disabled>
                                                        <input type="hidden" name="name"
                                                            value="{{ $enterprise->name }}">
                                                    @else
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ old('name', $enterprise->name ?? '') }}"
                                                            placeholder="Nhập tên doanh nghiệp">
                                                    @endif
                                                    @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email <span
                                                            class="text-danger">(*)</span></label>
                                                    @if (!empty($enterprise->email) && $enterprise->is_verify)
                                                        <input type="email" class="form-control" name="email"
                                                            value="{{ $enterprise->email }}" disabled>
                                                        <input type="hidden" name="email"
                                                            value="{{ $enterprise->email }}">
                                                    @else
                                                        <input type="email" class="form-control" name="email"
                                                            value="{{ old('email', $enterprise->email ?? '') }}"
                                                            placeholder="Nhập email">
                                                    @endif
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Website <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" name="url" class="form-control"
                                                        value="{{ old('url', $enterprise->url ?? '') }}"
                                                        placeholder="Nhập đường liên kết">
                                                    @error('url')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Số điện thoại <span
                                                            class="text-danger">(*)</span></label>
                                                    @if (!empty($enterprise->phone) && $enterprise->is_verify)
                                                        <input type="text" name="phone" class="form-control"
                                                            value="{{ $enterprise->phone }}" disabled>
                                                        <input type="hidden" name="phone"
                                                            value="{{ $enterprise->phone }}">
                                                    @else
                                                        <input type="text" name="phone" class="form-control"
                                                            value="{{ old('phone', $enterprise->phone ?? '') }}"
                                                            placeholder="Nhập số điện thoại">
                                                    @endif
                                                    @error('phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Mã số thuế <span
                                                            class="text-danger">(*)</span></label>
                                                    @if (!empty($enterprise->tax_code) && $enterprise->is_verify)
                                                        <input type="text" name="tax_code" class="form-control"
                                                            value="{{ $enterprise->tax_code }}" disabled>
                                                        <input type="hidden" name="tax_code"
                                                            value="{{ $enterprise->tax_code }}">
                                                    @else
                                                        <input type="text" name="tax_code" class="form-control"
                                                            value="{{ old('tax_code', $enterprise->tax_code ?? '') }}"
                                                            placeholder="Nhập mã số thuế">
                                                    @endif
                                                    @error('tax_code')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Địa chỉ <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" name="address" class="form-control"
                                                        value="{{ old('address', $enterprise->address ?? '') }}"
                                                        placeholder="Nhập địa chỉ">
                                                    @error('address')
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
                                                        @if (!empty($enterprise->logo) && filter_var($enterprise->logo, FILTER_VALIDATE_URL))
                                                            <img id="avatar-preview" src="{{ $enterprise->logo }}"
                                                                width="38px" alt="Avatar" class="box-image">
                                                        @elseif (!empty($enterprise->logo) && Storage::exists($enterprise->logo))
                                                            <img id="avatar-preview"
                                                                src="{{ Storage::url($enterprise->logo) }}"
                                                                width="38px" alt="Avatar" class="box-image">
                                                        @else
                                                            <img src="https://placehold.co/50" width="38px"
                                                                alt="Default Avatar" class="box-image">
                                                        @endif
                                                        <input type="file" name="logo" class="form-control"
                                                            id="avatar-input">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Quy mô</label>
                                                    <input type="number" name="size" class="form-control"
                                                        value="{{ old('size', $enterprise->size ?? '') }}"
                                                        placeholder="Nhập quy mô doanh nghiệp">
                                                    @error('size')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Giới thiệu</label>
                                                    <input type="text" name="introduce" class="form-control"
                                                        value="{{ old('introduce', $enterprise->introduce ?? '') }}"
                                                        placeholder="Nhập giới thiệu">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Lĩnh vực đào tạo</label>
                                                    <input type="text" name="industry" class="form-control"
                                                        value="{{ old('industry', $enterprise->industry ?? '') }}"
                                                        placeholder="Nhập lĩnh vực đào tạo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <label class="form-label">Mô tả</label>
                                                    <textarea name="description" id="editor1">{{ old('description', $enterprise->description ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-start gap-3 mt-4">
                                            <a href="#">
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
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor1'))
            .catch(error => {
                console.error(error);
            });

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
@endsection
