<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@polariscg.com.ar'],
            [
                'name' => 'Admin Polaris',
                'password' => \Illuminate\Support\Facades\Hash::make('polaris2026!'),
            ]
        );

        $this->call([
            ArticleSeeder::class,
        ]);
    }
}
