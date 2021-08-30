<?php

declare(strict_types=1);

namespace Domains\Trips\Factories;

use Domains\Trips\Enums\TripStatusEnum;
use Domains\Trips\Models\Trip;
use Domains\Users\Models\User;
use Illuminate\Support\Carbon;
use Parents\Factories\Factory;
use Parents\ValueObjects\CrmIdValueObject;
use Parents\ValueObjects\MoneyValueObject;
use Parents\ValueObjects\TimeValueObject;

final class TripFactory extends Factory
{
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @psalm-suppress UndefinedMagicPropertyFetch
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->address(),
            'where_address' => $this->faker->address(),
            'date' => Carbon::now(),
            'time' => TimeValueObject::fromNative($this->faker->time()),
            'childrens' => $this->faker->randomNumber(1),
            'duration' => $this->faker->randomNumber(1),
            'distance' => $this->faker->randomFloat(2, 10, 10000),
            'status' => TripStatusEnum::getRandomInstance(),
            'user_id' => function (): int {
                return User::factory()->create()->id;
            },
            'scheduled_wait_where' => $this->faker->randomNumber(2),
            'scheduled_wait_from' => $this->faker->randomNumber(2),
            'not_scheduled_wait_where' => $this->faker->randomNumber(2),
            'not_scheduled_wait_from' => $this->faker->randomNumber(2),
            'parking_cost' => MoneyValueObject::fromNative($this->faker->randomNumber(5)),
            'attendant_income' => MoneyValueObject::fromNative($this->faker->randomNumber(5)),
            'crmid' => CrmIdValueObject::fromNative(
                $this->faker->randomNumber(2) . 'x' . $this->faker->randomNumber(3)
            ),
            'cf_timetable_id' => CrmIdValueObject::fromNative(
                $this->faker->randomNumber(2) . 'x' . $this->faker->randomNumber(3)
            ),
            'assigned_user_id' => CrmIdValueObject::fromNative('19x1'),
            'description' => $this->faker->text(),
            'parking_info' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
