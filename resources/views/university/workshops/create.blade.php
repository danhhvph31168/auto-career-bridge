@extends('admin.layouts.master')

@section('content')
<style>
    .album-container {
        margin: 20px;
        font-family: Arial, sans-serif;
    }

    .upload-area {
        border: 2px dashed #d3d3d3;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: #a3a3a3;
    }

    .icon {
        margin-bottom: 10px;
    }

    .upload-text {
        color: #6c757d;
    }

    .image-preview {
        /* display: flex; */
        flex-wrap: wrap;
        margin-top: 20px;
        gap: 10px;
    }

    .image-preview img {
        max-width: 150px;
        max-height: 150px;
        border: 1px solid #ddd;
        border-radius: 5px;
        object-fit: cover;
    }
</style>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">{{ $config['index']['title'] }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lí workshop</a></li>
                            <li class="breadcrumb-item active">Thêm mới workshop</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <form action="{{ route('university.workshop.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Cột bên phải (Form nhập liệu) -->
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tiêu đề <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control" name="title"
                                                    value="{{ old('title') }}" placeholder="Nhập tiêu đề">
                                                @error('title')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Điều kiện <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control" name="requirement"
                                                    value="{{ old('requirement') }}" placeholder="Nhập điều kiện">
                                                @error('requirement')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Địa chỉ <span
                                                        class="text-danger"> (*)</span></label>
                                                <input type="text" name="address" class="form-control"
                                                    value="{{ old('address') }}" placeholder="Nhập địa chỉ">
                                                @error('address')
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
                                                    @foreach ($majors as $major)
                                                    <option value="{{ $major->id }}"
                                                        {{ in_array($major->id, old('majors', [])) ? 'selected' : '' }}>
                                                        {{ $major->name }}
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
                                                <label class="form-label">Ngày bắt đầu <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="date" name="start_date" class="form-control"
                                                    value="{{ old('start_date') }}">
                                                @error('start_date')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Ngày kết thúc <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="date" name="end_date" class="form-control"
                                                    value="{{ old('end_date') }}">
                                                @error('end_date')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="form-label">Mô tả <span
                                                    class="text-danger">(*)</span></label>
                                            <textarea name="description" id="editor">{{ old('description') }}</textarea>

                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <a href="{{ route('university.workshop.index') }}">
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
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div>
    </div>
</div>
<script>
    function handleFiles(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('imagePreviewContainer');
        previewContainer.innerHTML = '';

        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else {
                alert('Chỉ hỗ trợ các tệp hình ảnh!');
            }
        });
    }
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
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