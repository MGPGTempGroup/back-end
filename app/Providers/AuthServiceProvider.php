<?php

namespace App\Providers;

use App\CustomerRemark;
use App\LeaseRemark;
use App\Policies\Admin\CustomerRemarkPolicy;
use App\Policies\Admin\LeaseRemarkPolicy;
use App\Policies\Admin\ResidenceRemarkPolicy;
use App\ResidenceRemark;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        CustomerRemark::class => CustomerRemarkPolicy::class,
        ResidenceRemark::class => ResidenceRemarkPolicy::class,
        LeaseRemark::class => LeaseRemarkPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
