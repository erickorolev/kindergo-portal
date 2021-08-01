<?php

declare(strict_types=1);

namespace Domains\Payments\Factories;

use Domains\Payments\Enums\AttendantSignatureEnum;
use Domains\Payments\Enums\PayTypeEnum;
use Domains\Payments\Enums\SpStatusEnum;
use Domains\Payments\Enums\TypePaymentEnum;
use Domains\Payments\Models\Payment;
use Domains\Users\Models\User;
use Illuminate\Support\Carbon;
use Parents\Factories\Factory;
use Parents\ValueObjects\CrmIdValueObject;
use Parents\ValueObjects\MoneyValueObject;

final class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @psalm-suppress UndefinedMagicPropertyFetch
     */
    public function definition(): array
    {
        return [
            'pay_date' => Carbon::now(),
            'pay_type' => PayTypeEnum::getRandomInstance(),
            'attendanta_signature' => AttendantSignatureEnum::getRandomInstance(),
            'dispute_reason' => $this->faker->sentence(),
            'amount' => MoneyValueObject::fromNative($this->faker->numberBetween(10000, 1000000)),
            'spstatus' => SpStatusEnum::getRandomInstance(),
            'crmid' => CrmIdValueObject::fromNative(
                $this->faker->randomNumber(2) . 'x' . $this->faker->randomNumber(3)
            ),
            'assigned_user_id' => CrmIdValueObject::fromNative('19x1'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => function (): int {
                return User::factory()->create()->id;
            },
        ];
    }
}
