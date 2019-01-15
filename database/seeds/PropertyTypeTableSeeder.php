<?php

use Illuminate\Database\Seeder;

class PropertyTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $propertyTypes = ['house', 'unit', 'apartment', 'studio', 'townHouse', 'terrace', 'villa', 'semi', 'duplex', 'penthouse'];
        foreach ($propertyTypes as $propertyType) {
            factory(App\PropertyType::class)->create([
                'name' => $propertyType
            ]);
        }
    }
}
