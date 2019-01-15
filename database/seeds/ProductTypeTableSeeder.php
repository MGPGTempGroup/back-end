<?php

use Illuminate\Database\Seeder;

class ProductTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productTypes = ['house', 'unit', 'apartment', 'studio', 'townHouse', 'terrace', 'villa', 'semi', 'duplex', 'penthouse'];
        foreach ($productTypes as $productType) {
            factory(App\ProductType::class)->create([
                'name' => $productType
            ]);
        }
    }
}
