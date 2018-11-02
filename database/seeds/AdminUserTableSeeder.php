<?php

use Illuminate\Database\Seeder;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AdminUser::class)->create([
            'name' => 'NicoLi',
            'email' => 'nico.li@outlook.com'
        ]);
        factory(App\AdminUser::class)->create([
            'name' => 'TingtingGao',
            'email' => 'tingting-gao@outlook.com'
        ]);
    }
}
