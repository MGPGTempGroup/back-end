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
        $productTypes = ['House', 'Unit', 'Apartment', 'Studio', 'Townhouse', 'Terrace', 'Villa', 'Semi', 'Duplex', 'Penthouse'];
        foreach ($productTypes as $productType) {
            factory(App\ProductType::class)->create([
                'name' => $productType
            ]);
        }
    }
}
