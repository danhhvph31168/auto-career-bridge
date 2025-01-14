<?php

namespace App\Console\Commands;

use App\Models\Job;
use App\Services\Enterprise\JobService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateJobIsActive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:update-job-is-active';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cập nhật trạng thái is_active dựa vào start_date và end_date';

    public function __construct(protected JobService $jobService)
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->jobService->updateStatusByDate();

        $this->info('Tự động thay đổi is_active của table jobs đã được chạy, sẽ thay đổi hàng ngày vào 0h00');
    }
}
