<?php

use Illuminate\Database\Seeder;

class CompanyMemberPositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'Corporate' => ['Founder', 'Office Manager', 'General Manager'],
            'Project Sales' => ['Project Sales Director', 'Project sales Coordinator'],
            'Residential Sales' => ['Senior Sales Executive', 'Residential Sales Executive'],
            'Business Development' => ['Head of Business Development', 'Development Leasing Manager'],
            'Property Management' => ['Property Management Operations Manager', 'Team Leader'],
            'Residential Leasing' => ['Leasing Consultant', 'Leasing Consultant'],
            'Customer Service and Administration' => ['Administration Team Leader', 'Property Management Administrator']
        ];
        $id = 1;
        foreach ($departments as $positions) {
            foreach ($positions as $position) {
                factory(App\CompanyMemberPosition::class)->create([
                    'department_id' => $id,
                    'name' => $position
                ]);
            }
            $id++;
        }
    }
}
