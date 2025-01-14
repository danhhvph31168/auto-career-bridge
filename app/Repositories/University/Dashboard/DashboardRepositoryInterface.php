<?php

namespace App\Repositories\University\Dashboard;

interface DashboardRepositoryInterface
{
    public function getWorkshop();

    public function getWorkshopApply();

    public function getCooperate();

    public function getJobUniversity();

    public function getFeaturedWorkshop($perPage);

    public function getDateDashboard($startDate, $endDate);

    public function getMonth();
}
