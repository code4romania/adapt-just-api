<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory()->create([
             'first_name' => 'Iacob',
             'last_name' => 'Catalin',
             'email' => 'catalin.iacob@web-group.ro',
         ]);

         Artisan::call('permission:update');
         Artisan::call('permission:give 1');
    }
}
