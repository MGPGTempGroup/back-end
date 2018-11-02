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
        $propertyTypes = ['House', 'Unit', 'Apartment', 'Studio', 'Townhouse', 'Terrace', 'Villa', 'Semi', 'Duplex', 'Penthouse'];
        foreach ($propertyTypes as $propertyType) {
            factory(App\PropertyType::class)->create([
                'name' => $propertyType
            ]);
        }
    }
}
