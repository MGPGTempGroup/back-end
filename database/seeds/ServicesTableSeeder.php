<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            'landlords', 'prospective_tenants', 'current_tenants', 'areas_we_serve',
            'project_marketing', 'project_leasing', 'commercial', 'sell', 'careers'
        ];
        foreach ($services as $k => $v) {
            factory(App\Service::class)->create([
                'name' => $v
            ]);
        }
    }
}
