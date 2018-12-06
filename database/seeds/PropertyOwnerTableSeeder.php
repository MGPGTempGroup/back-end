<?php

use Illuminate\Database\Seeder;

class PropertyOwnerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PropertyOwner::class, 10)->create();
    }
}
