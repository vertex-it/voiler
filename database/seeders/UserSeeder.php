<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! User::whereEmail('admin@admin.com')->exists()) {
            User::factory()->create([
                'name' => 'Superadmin',
                'email' => 'admin@admin.com',
                'username' => 'superadmin',
            ])->assignRole('superadmin');

            User::factory()->create([
                'name' => 'Taylor Otwell',
                'email' => 'taylor@otwell.com',
                'username' => 'taylor',
            ])->assignRole('user');
        }
    }
}
