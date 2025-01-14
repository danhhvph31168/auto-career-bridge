<div>
    <div class="search-job">
        <div class="row">
            <div class="col-lg-5">
                <div class="form-group">
                    <input type="text" class="form-control" id="job-title" name="keyword" wire:model="keyword"
                        placeholder="Vị trí tuyển dụng, tên công ty">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="address" wire:ignore>
                    <select id="province" class="province list-option">
                        <option value="">Tỉnh thành phố</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-3">
                <button type="button" class="default-btn" wire:click="getDataSearch" wire:init="getDataSearch">
                    <i class="bx bx-search"></i>
                    Tìm kiếm
                </button>
            </div>
        </div>
    </div>

    <div class="time-and-hour">
        <div class="row">
            <div class="col-lg-6">
                <div class="rated" wire:ignore>
                    <select name="major" wire:model="major" id="major-select">
                        <option value="">Lĩnh vực</option>
                        @if (isset($majors) && !empty($majors))
                            @foreach ($majors as $major)
                                <option value="{{ $major->id }}">
                                    {{ $major->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="show-page" wire:ignore>
                    <p>Số lượng bản ghi</p>
                    <select name="perpage" wire:model="perpage" id="perpage-select">
                        @for ($i = 5; $i <= 50; $i += 10)
                            <option value="{{ $i }}" {{ request()->perpage == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
    </div>


</div>
