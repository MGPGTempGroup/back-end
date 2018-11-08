<?php

use Illuminate\Database\Seeder;

class CustomerIdentityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $identities = ['Landlord', 'Tenant', 'Purchaser', 'Vendor', 'Other'];
        foreach ($identities as $identity) {
            factory(App\CustomerIdentity::class)->create([
                'name' => $identity
            ]);
        }
    }
}
