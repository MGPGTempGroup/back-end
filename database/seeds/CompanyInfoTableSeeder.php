<?php

use Illuminate\Database\Seeder;

class CompanyInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CompanyInfo::class, 1)->create();
    }
}
