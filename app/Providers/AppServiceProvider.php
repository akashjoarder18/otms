<?php

namespace App\Providers;

use App\Models\PrelimarySelection;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\SubCategoryRepository;
use App\Repositories\Interfaces\SubCategoryRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;


use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\AdminRepository;

use App\Repositories\DivisionRepository;
use App\Repositories\Interfaces\DivisionRepositoryInterface;

use App\Repositories\DistrictRepository;
use App\Repositories\Interfaces\DistrictRepositoryInterface;

use App\Repositories\UpazilaRepository;
use App\Repositories\Interfaces\UpazilaRepositoryInterface;
use App\Repositories\Interfaces\UserDetailRepositoryInterface;
use App\Repositories\Interfaces\UserlogRepositoryInterface;
use App\Repositories\UserDetailRepository;
use App\Repositories\UserlogRepository;

use App\Repositories\ProviderRepository;
use App\Repositories\Interfaces\ProviderRepositoryInterface;
use App\Repositories\CommitteeRepository;
use App\Repositories\Interfaces\CommitteeRepositoryInterface;
use App\Repositories\PreliminarySelectionRepository;
use App\Repositories\Interfaces\PreliminarySelectionRepositoryInterface;


use App\Repositories\TraineeEnrollRepository;
use App\Repositories\Interfaces\TraineeEnrollRepositoryInterface;
use App\Repositories\TrainerEnrollRepository;
use App\Repositories\Interfaces\TrainerEnrollRepositoryInterface;

use App\Repositories\PermissionRepository;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

use App\Repositories\RoleRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;

use App\Repositories\RoleHasPermissionRepository;
use App\Repositories\Interfaces\RoleHasPermissionRepositoryInterface;

use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(SubCategoryRepositoryInterface::class, SubCategoryRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(DivisionRepositoryInterface::class, DivisionRepository::class);
        $this->app->bind(DistrictRepositoryInterface::class, DistrictRepository::class);
        $this->app->bind(UpazilaRepositoryInterface::class, UpazilaRepository::class);
        $this->app->bind(UserDetailRepositoryInterface::class, UserDetailRepository::class);
        $this->app->bind(UserlogRepositoryInterface::class, UserlogRepository::class);
        $this->app->bind(ProviderRepositoryInterface::class, ProviderRepository::class);
        $this->app->bind(CommitteeRepositoryInterface::class, CommitteeRepository::class);
        $this->app->bind(PreliminarySelectionRepositoryInterface::class, PreliminarySelectionRepository::class);
        $this->app->bind(TraineeEnrollRepositoryInterface::class, TraineeEnrollRepository::class);
        $this->app->bind(TrainerEnrollRepositoryInterface::class, TrainerEnrollRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(RoleHasPermissionRepositoryInterface::class, RoleHasPermissionRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
