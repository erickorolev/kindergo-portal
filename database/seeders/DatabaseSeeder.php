<?php

namespace Database\Seeders;

use Domains\Authorization\Seeders\PermissionsSeeder;
use Domains\Children\Seeders\ChildSeeder;
use Domains\Payments\Seeders\PaymentSeeder;
use Domains\Users\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(ChildSeeder::class);
        $this->call(PaymentSeeder::class);
    }
}
