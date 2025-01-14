<?php

namespace App\Providers;

use App\Livewire\Admin\University\MajorListComponent;
use Livewire\Livewire;
// bind base repository


use App\Repositories\BaseRepository;
use Illuminate\Pagination\Paginator;
use App\Repositories\Job\JobRepository;
use App\Repositories\Users\UserRepository;
use App\Repositories\Major\MajorRepository;
use App\Repositories\Auth\RegisterRepository;
use App\Repositories\BaseRepositoryInterface;
use App\Repositories\Job\JobRepositoryInterface;
use App\Repositories\Users\UserRepositoryInterface;
use App\Repositories\Major\MajorRepositoryInterface;
use App\Livewire\Admin\University\UserListComponent;
use App\Livewire\Admin\University\WorkshopListComponent;
use App\Livewire\Workshops\WorkshopComponent;
use App\Repositories\Auth\RegisterRepositoryInterface;
// bind profile university repository
use App\Repositories\University\Profile\ProfileRepository;
use App\Repositories\University\Profile\ProfileRepositoryInterface;

// bind dashboard enteprises repository
use App\Repositories\Enterprises\Dashboard\DashboardRepository;
use App\Repositories\Enterprises\Dashboard\DashboardRepositoryInterface;

// bind dashboard enteprises repository
use App\Repositories\University\Dashboard\DashboardRepository as DashboardUniversityRepo;
use App\Repositories\University\Dashboard\DashboardRepositoryInterface as DashboardUniversityRepoInterface;

// bind workshops repository
use App\Repositories\University\Workshop\WorkShopRepository;
use App\Repositories\University\Workshop\WorkShopRepositoryInterface;

use App\Repositories\Enterprises\User\UserRepository as UserUserRepository;
use App\Repositories\Enterprises\User\UserRepositoryInterface as UserUserRepositoryInterface;

use App\Repositories\SubAdmin\SubAdminRepository;
use App\Repositories\SubAdmin\SubAdminRepositoryInterface;


// bind university repository
use App\Repositories\University\User\UserRepository as UserUniversityRepository;
use App\Repositories\University\{UniversityRepository, UniversityRepositoryInterface};
use App\Repositories\University\User\UserRepositoryInterface as UserUniversityRepositoryInterface;
use App\Repositories\NotificationsEnterprises\{NotificationRepository, NotificationRepositoryInterface};
use App\Services\Admin\UniversityService;

//bind approve enterprise repository
use App\Repositories\Admin\Enterprise\EnterpriseRepository;
use App\Repositories\Admin\Enterprise\EnterpriseRepositoryInterface;

// bind admin approve job repository
use App\Repositories\Admin\Job\JobRepository as AdminJobRepository;
use App\Repositories\Admin\Job\JobRepositoryInterface as AdminJobRepositoryInterface;

use App\Repositories\Enterprises\EnterpriseRepository as EnterprisesEnterpriseRepository;
use App\Repositories\Enterprises\EnterpriseRepositoryInterface as EnterprisesEnterpriseRepositoryInterface;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

//bind collaboration repository
use App\Repositories\Collaboration\CollaborationRepository;
use App\Repositories\Collaboration\CollaborationRepositoryInterface;

//bind notification repository
use App\Repositories\Notification\NotificationRepository as NotificationNotificationRepository;
use App\Repositories\Notification\NotificationRepositoryInterface as NotificationNotificationRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);

        $this->app->bind(SubAdminRepositoryInterface::class, SubAdminRepository::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(WorkShopRepositoryInterface::class, WorkShopRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(UniversityRepositoryInterface::class, UniversityRepository::class);
        $this->app->bind(UserUniversityRepositoryInterface::class, UserUniversityRepository::class);
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
        $this->app->bind(MajorRepositoryInterface::class, MajorRepository::class);
        $this->app->bind(RegisterRepositoryInterface::class, RegisterRepository::class);
        $this->app->bind(UserUserRepositoryInterface::class, UserUserRepository::class);
        $this->app->bind(DashboardRepositoryInterface::class, DashboardRepository::class);
        $this->app->bind(DashboardUniversityRepoInterface::class, DashboardUniversityRepo::class);
        $this->app->bind(EnterprisesEnterpriseRepositoryInterface::class, EnterprisesEnterpriseRepository::class);
        $this->app->bind(CollaborationRepositoryInterface::class, CollaborationRepository::class);
        $this->app->bind(NotificationNotificationRepositoryInterface::class, NotificationNotificationRepository::class);
        Livewire::component('admin-university-component', UserListComponent::class);
        Livewire::component('admin-workshop-component', WorkshopListComponent::class);
        Livewire::component('client-workshop-component', WorkshopComponent::class);
        Livewire::component('admin-major-component', MajorListComponent::class);
        $this->app->bind(UniversityService::class);
        $this->app->bind(EnterpriseRepositoryInterface::class, EnterpriseRepository::class);

        $this->app->bind(AdminJobRepositoryInterface::class, AdminJobRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Validator::extend('strong_password', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $value);
        });
    }
}
