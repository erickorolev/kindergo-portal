<?php

declare(strict_types=1);

namespace Domains\Users\Seeders;

use Domains\Users\Models\User;
use Parents\Seeders\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('password'),
            ]);
        User::factory()
            ->count(5)
            ->create();
    }
}
