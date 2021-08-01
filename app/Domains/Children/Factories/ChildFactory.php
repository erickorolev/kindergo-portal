<?php

declare(strict_types=1);

namespace Domains\Children\Factories;

use Domains\Children\Models\Child;
use Parents\Enums\GenderEnum;
use Parents\Factories\Factory;
use Parents\ValueObjects\CrmIdValueObject;
use Parents\ValueObjects\PhoneNumberValueObject;

final class ChildFactory extends Factory
{
    protected $model = Child::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'middle_name' => $this->faker->text(15),
            'birthday' => $this->faker->date(),
            'gender' => GenderEnum::getRandomInstance(),
            'phone' => PhoneNumberValueObject::fromNative($this->faker->phoneNumber()),
            'otherphone' => PhoneNumberValueObject::fromNative($this->faker->phoneNumber()),
            'crmid' => CrmIdValueObject::fromNative(
                $this->faker->randomNumber(2) . 'x' . $this->faker->randomNumber(3)
            ),
            'assigned_user_id' => CrmIdValueObject::fromNative('19x1'),
        ];
    }
}
