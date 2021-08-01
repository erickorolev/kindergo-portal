<?php

declare(strict_types=1);

namespace Domains\Payments\Seeders;

use Domains\Payments\Models\Payment;
use Parents\Seeders\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Payment::factory()
            ->count(5)
            ->create();
    }
}
