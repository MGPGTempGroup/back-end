<?php

use Illuminate\Database\Seeder;

class CompanyDepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'Corporate',
            'Project Sales',
            'Residential Sales',
            'Business Development',
            'Property Management',
            'Residential Leasing',
            'Customer Service and Administration'
        ];
        foreach ($departments as $k => $v) {
            factory(App\CompanyDepartment::class)->create([
                'name' => $v
            ]);
        }
    }
}
