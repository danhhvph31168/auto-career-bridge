<div class="col-lg-4">
    <div class="job-listing-sidebar">
        <div class="job-listing-widget">
            <ul class="accordion-widget">
                <li class="accordion-item">
                    <a class="accordion-widget-title active" href="javascript:void(0)">
                        <h3>Hình thức làm việc</h3>
                        <i class="bx bx-chevron-down"></i>
                    </a>

                    <ul class="accordion-widget-content show">
                        <li>
                            <label class="single-check">
                                Tất cả
                                <input type="radio" class="type" name="type" value="" wire:model="type"
                                    wire:click="sendDataToSearchComponent">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label class="single-check">
                                Toàn thời gian
                                <input type="radio" class="type" name="type" value="{{ FULL_TIME }}"
                                    wire:model="type" wire:click="sendDataToSearchComponent">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label class="single-check">
                                Bán thời gian
                                <input type="radio" class="type" name="type" value="{{ PART_TIME }}"
                                    wire:model="type" wire:click="sendDataToSearchComponent">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label class="single-check">
                                Làm việc từ xa
                                <input type="radio" class="type" name="type" value="{{ REMOTE }}"
                                    wire:model="type" wire:click="sendDataToSearchComponent">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="job-listing-widget">
            <ul class="accordion-widget">
                <li class="accordion-item">
                    <a class="accordion-widget-title active" href="javascript:void(0)">
                        <h3>Lương</h3>
                        <i class="bx bx-chevron-down"></i>
                    </a>

                    <ul class="accordion-widget-content show">
                        <li>
                            <div class="price-range-content" wire:ignore>
                                <div class="price-range-bar" id="range-slider">
                                </div>
                                <div class="price-range-filter">
                                    <div class="price-range-filter-item">
                                        <input type="text" id="price-amount" class="" name="salary" readonly
                                            value="" wire:model="salary">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="job-listing-widget">
            <ul class="accordion-widget">
                <li class="accordion-item">
                    <a class="accordion-widget-title active" href="javascript:void(0)">
                        <h3>Kinh nghiệm</h3>
                        <i class="bx bx-chevron-down"></i>
                    </a>

                    <ul class="accordion-widget-content show">
                        <li>
                            <label class="single-check">
                                {{ NO_EXPERIENCE }}
                                <input type="radio" class="experience_level" name="experience_level"
                                    value="{{ NO_EXPERIENCE }}" wire:click="sendDataToSearchComponent"
                                    wire:model="experience_level">
                                <span class="checkmark "></span>
                            </label>
                        </li>
                        <li>
                            <label class="single-check">
                                {{ ONE_YEAR }}
                                <input type="radio" class="experience_level" name="experience_level"
                                    value="{{ ONE_YEAR }}" wire:click="sendDataToSearchComponent"
                                    wire:model="experience_level">
                                <span class="checkmark "></span>
                            </label>
                        </li>
                        <li>
                            <label class="single-check">
                                {{ TWO_YEAR }}
                                <input type="radio" class="experience_level" name="experience_level"
                                    value="{{ TWO_YEAR }}" wire:click="sendDataToSearchComponent"
                                    wire:model="experience_level">
                                <span class="checkmark "></span>
                            </label>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        $("#range-slider").on("mouseup", function() {
            Livewire.dispatch('updatedSalary', {
                salary: $("#price-amount").val()
            })
        })
    })
</script>
