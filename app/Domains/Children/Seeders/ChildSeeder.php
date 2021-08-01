<?php

declare(strict_types=1);

namespace Domains\Children\Seeders;

use Domains\Children\Models\Child;
use Parents\Seeders\Seeder;

final class ChildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Child::factory()
            ->count(5)
            ->create();
    }
}
