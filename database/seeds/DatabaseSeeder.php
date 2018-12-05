<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(UsersTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(CompanyDepartmentsTableSeeder::class);
        $this->call(CompanyMemberPositionsTableSeeder::class);
        $this->call(CustomerIdentityTableSeeder::class);
        $this->call(PropertyTypeTableSeeder::class);
        $this->call(AdminUserTableSeeder::class);
        $this->call(ProductTypeTableSeeder::class);
    }
}
