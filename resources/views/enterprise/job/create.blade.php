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
                        <h4 class="mb-sm-0">{{ config('admin.enterprise.jobs.create .title') }}</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">{{ config('admin.enterprise.jobs.create .description') }}</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('enterprise.jobs.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <!-- Cột bên phải (Form nhập liệu) -->

                                <div class="row">
                                    {{-- <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Nhập mã <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" name="slug" class="form-control"
                                                        placeholder="Nhập mã" value="{{ old('slug') }}">
                                                    @error('slug')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                            </div> --}}
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tiêu đề <span class="text-danger">(*)</span></label>
                                            <input type="text"
                                                class="form-control @error('title')
                                                            is-invalid
                                                        @enderror"
                                                name="title" value="{{ old('title') }}" placeholder="Nhập tiêu đề">
                                            @error('title')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Thời gian làm việc <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text"
                                                        class="form-control @error('working_time')
                                                                        is-invalid
                                                                    @enderror"
                                                        name="working_time" value="{{ old('working_time') }}"
                                                        placeholder="Nhập thời gian làm việc">
                                                    @error('working_time')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Chuyên ngành <span
                                                            class="text-danger">(*)</span></label>
                                                    <select name="major_id"
                                                        class="form-select
                                                            @error('major_id')
                                                                        is-invalid
                                                                    @enderror"
                                                        aria-label="Default select example">
                                                        <option selected value=""></option>
                                                        @foreach ($majors as $major)
                                                            <option value="{{ $major['id'] }}"
                                                                {{ old('major_id') == $major['id'] ? 'selected' : '' }}>
                                                                {{ $major['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('major_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Yêu cầu <span class="text-danger">(*)</span></label>
                                            <input type="text"
                                                class="form-control @error('requirement')
                                                            is-invalid
                                                        @enderror"
                                                name="requirement" value="{{ old('requirement') }}"
                                                placeholder="Nhập điều kiện">
                                            @error('requirement')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Số lượng ứng viên<span
                                                    class="text-danger">(*)</span></label>
                                            <input type="text" name="applicants" class="form-control"
                                                value="{{ old('applicants') }}" placeholder="Nhập số lượng ứng viên">
                                            @error('applicants')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Địa chỉ<span class="text-danger">(*)</span></label>
                                            <input type="text" name="address"
                                                class="form-control @error('address')
                                                            is-invalid
                                                        @enderror"
                                                value="{{ old('address') }}" placeholder="Nhập địa chỉ">
                                            @error('address')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Lợi ích <span class="text-danger">(*)</span></label>
                                            <input type="text" name="benefit" placeholder="Nhập lợi ích"
                                                class="form-control  @error('benefit')
                                                    is-invalid
                                                @enderror"
                                                value="{{ old('benefit') }}">
                                            @error('benefit')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Kinh nghiệm <span
                                                            class="text-danger">(*)</span></label>
                                                    <select name="experience_level"
                                                        class="form-select
                                                            @error('experience_level')
                                                                        is-invalid
                                                                    @enderror"
                                                        aria-label="Default select example">
                                                        <option selected value=""></option>
                                                        <option value="{{ NO_EXPERIENCE }}" @selected(old('experience_level') == NO_EXPERIENCE)>
                                                            {{ NO_EXPERIENCE }}
                                                        </option>
                                                        <option value="{{ ONE_YEAR }}" @selected(old('experience_level') == ONE_YEAR)>
                                                            {{ ONE_YEAR }}
                                                        </option>
                                                        <option value="{{ TWO_YEAR }}" @selected(old('experience_level') == TWO_YEAR)>
                                                            {{ TWO_YEAR }}
                                                        </option>
                                                    </select>
                                                    @error('experience_level')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Cách thức làm việc <span
                                                            class="text-danger">(*)</span></label>
                                                    <select name="type"
                                                        class="form-select
                                                            @error('type')
                                                                        is-invalid
                                                                    @enderror"
                                                        aria-label="Default select example">
                                                        <option selected value=""></option>
                                                        <option value="{{ FULL_TIME }}" @selected(old('type') == FULL_TIME)>
                                                            Toàn thời gian
                                                        </option>
                                                        <option value="{{ PART_TIME }}" @selected(old('type') == PART_TIME)>
                                                            Bán thời gian
                                                        </option>
                                                        <option value="{{ REMOTE }}" @selected(old('type') == REMOTE)>
                                                            Làm việc từ xa
                                                        </option>
                                                    </select>
                                                    @error('type')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Ngày bắt đầu <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="date" name="start_date"
                                                        class="form-control @error('start_date')
                                                            is-invalid
                                                        @enderror"
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
                                                    <input type="date" name="end_date"
                                                        class="form-control  @error('end_date')
                                                            is-invalid
                                                        @enderror"
                                                        value="{{ old('end_date') }}">
                                                    @error('end_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Lương <span class="text-danger">(*)</span></label>
                                            <input type="number"
                                                class="form-control @error('salary')
                                                            is-invalid
                                                        @enderror"
                                                name="salary" value="{{ old('salary') }}" placeholder="Nhập lương">
                                            @error('salary')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Trạng thái <span
                                                    class="text-danger">(*)</span></label>
                                            <div class="d-flex">
                                                <div class="form-check form-radio-outline form-radio-success mt-2">
                                                    <input class="form-check-input" type="radio" name="is_active"
                                                        id="activeStatus" value="1" checked>
                                                    <label class="form-check-label" for="activeStatus">
                                                        Hoạt động
                                                    </label>
                                                </div>
                                                <div class="form-check form-radio-outline form-radio-danger mt-2 ms-3">
                                                    <input class="form-check-input" type="radio" name="is_active"
                                                        id="inactiveStatus" value="0">
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

                                    <div class="col-lg-12">
                                        <label class="form-label">Mô tả <span class="text-danger">(*)</span></label>
                                        <textarea name="description" id="editor">{{ old('description') }}</textarea>
                                        @error('description')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <a href="{{ route('enterprise.jobs.index') }}">
                                        <button type="button" class="btn btn-outline-dark btn-label">
                                            <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                            {{ config('admin.enterprise.jobs.return') }}
                                        </button>
                                    </a>
                                    <button type="submit" class="btn btn-success btn-label right ms-auto">
                                        <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                        {{ config('admin.enterprise.jobs.create .button') }}
                                    </button>
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
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
