@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ config('admin.enterprise.jobs.edit.title') }}</h4>
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
                            <form action="{{ route('enterprise.jobs.update', $job) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <!-- Cột bên phải (Form nhập liệu) -->

                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tiêu đề <span class="text-danger">(*)</span></label>
                                            <input type="text"
                                                class="form-control @error('title')
                                                            is-invalid
                                                        @enderror"
                                                name="title" value="{{ $job->title }}" placeholder="Nhập tiêu đề">
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
                                                        name="working_time" value="{{ $job->working_time }}"
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
                                                                {{ $job->major_id == $major['id'] ? 'selected' : '' }}>
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
                                                name="requirement" value="{{ $job->requirement }}"
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
                                                value="{{ $job->address }}" placeholder="Nhập địa chỉ">
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
                                                value="{{ $job->benefit }}">
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
                                                        <option value="{{ NO_EXPERIENCE }}" @selected($job->experience_level == NO_EXPERIENCE)>
                                                            {{ NO_EXPERIENCE }}
                                                        </option>
                                                        <option value="{{ ONE_YEAR }}" @selected($job->experience_level == ONE_YEAR)>
                                                            {{ ONE_YEAR }}
                                                        </option>
                                                        <option value="{{ TWO_YEAR }}" @selected($job->experience_level == TWO_YEAR)>
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
                                                        <option value="{{ FULL_TIME }}" @selected($job->type == FULL_TIME)>
                                                            Toàn thời gian
                                                        </option>
                                                        <option value="{{ PART_TIME }}" @selected($job->type == PART_TIME)>
                                                            Bán thời gian
                                                        </option>
                                                        <option value="{{ REMOTE }}" @selected($job->type == REMOTE)>
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
                                                        value="{{ $job->start_date }}">
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
                                                        value="{{ $job->end_date }}">
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
                                                name="salary" value="{{ $job->salary }}" placeholder="Nhập lương">
                                            @error('salary')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label">Trạng thái <span
                                                            class="text-danger">(*)</span></label>
                                                    <div class="d-flex">
                                                        <div class="form-check form-radio-outline form-radio-success mt-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_active" id="activeStatus" value="1"
                                                                {{ $job->is_active == IS_ACTIVE ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="activeStatus">
                                                                Hoạt động
                                                            </label>
                                                        </div>
                                                        <div
                                                            class="form-check form-radio-outline form-radio-danger mt-2 ms-3">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_active" id="inactiveStatus" value="0"
                                                                {{ $job->is_active == UN_ACTIVE ? 'checked' : '' }}>
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
                                            @php
                                                $statusLabels = [
                                                    PENDING_APPROVE => [
                                                        'class' => 'bg-warning',
                                                        'text' => 'Chờ duyệt',
                                                    ],
                                                    UN_APPROVE => [
                                                        'class' => 'bg-danger',
                                                        'text' => 'Từ chối',
                                                    ],
                                                    APPROVED => [
                                                        'class' => 'bg-success',
                                                        'text' => 'Đã duyệt',
                                                    ],
                                                ];
                                            @endphp
                                            <div class="col">
                                                <div class="mb-3">
                                                    <h6 class="fw-semibold">Phê duyệt
                                                    </h6>
                                                    <span
                                                        class="badge  {{ $statusLabels[$job->status]['class'] }} px-3 py-2 rounded-pill">
                                                        {{ $statusLabels[$job->status]['text'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="form-label">Mô tả <span class="text-danger">(*)</span></label>
                                        <textarea name="description" id="editor">{{ $job->description }}</textarea>
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
                                        {{ config('admin.enterprise.jobs.edit.button') }}
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
