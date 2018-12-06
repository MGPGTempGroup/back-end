<?php

use Illuminate\Database\Seeder;

class CompanyMemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $availablePositionsId = App\CompanyMemberPosition::select('id')->pluck('id')->toArray();
        factory(App\CompanyMember::class, 10)
            ->create()
            ->each(function ($member) use ($availablePositionsId) {
                $member->positions()->sync(array_rand($availablePositionsId, mt_rand(1,3)));
            });
    }
}
