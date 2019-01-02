<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class EloquentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'residences' => 'App\Residence',
            'leases' => 'App\Lease',
            'property_owners' => 'App\PropertyOwner',
            'service_messages' => 'App\ServiceMessage',
            'house_inspections' => 'App\HouseInspection',
            'company_members' => 'App\CompanyMember',
            'projects' => 'App\Project'
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
