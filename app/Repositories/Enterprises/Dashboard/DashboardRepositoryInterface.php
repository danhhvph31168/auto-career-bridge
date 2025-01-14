<?php

namespace App\Repositories\Enterprises\Dashboard;

interface DashboardRepositoryInterface
{
    public function getJob();

    public function getJobApply();

    public function getCooperate();

    public function getWorkshop();

    public function getFeaturedJob($perPage);

    public function getDateDashboard($startDate, $endDate);

    public function getMonth();
}
