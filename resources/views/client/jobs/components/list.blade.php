<section class="job-listing-area ptb-100">
    <div class="container ">
        <div class="row">
            <div class="col-lg-8">
                @livewire('jobs.search-component')

                @livewire('jobs.list-component')
            </div>
            @livewire('jobs.filter-component')

        </div>
    </div>
</section>
<style>
    .address .nice-select {
        width: 100% !important;
        border-radius: 0;
        /* border-color: #ccc; */
        box-shadow: 0px 5px 20px 3px rgba(230, 233, 249, .9);
        padding: 10px 20px;
        font-size: 16px;
        height: 50px !important;
    }

    .address .nice-select .current {
        position: relative;
        top: -6px;
    }

    .nice-select::after {
        width: 7px !important;
        height: 7px !important;
    }
</style>
