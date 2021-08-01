<?php

declare(strict_types=1);

namespace Domains\Trips\Seeders;

use Domains\Trips\Models\Trip;
use Parents\Seeders\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Trip::factory()
            ->count(5)
            ->create();
    }
}
