<?php

namespace Domains\Users\Factories;

use Domains\Users\Enums\AttendantCategoryEnum;
use Domains\Users\Enums\AttendantGenderEnum;
use Domains\Users\Enums\AttendantStatusEnum;
use Domains\Users\Models\User;
use Domains\Users\ValueObjects\FullNameValueObject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Parents\Enums\GenderEnum;
use Parents\ValueObjects\CrmIdValueObject;
use Parents\ValueObjects\EmailValueObject;
use Parents\ValueObjects\PhoneNumberValueObject;
use Parents\ValueObjects\UrlValueObject;

final class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => FullNameValueObject::fromNative(
                $this->faker->firstName(),
                $this->faker->lastName(),
                null
            ),
            'email' => $this->faker->email(),
            'email_verified_at' => now(),
            'password' => \Hash::make('password'),
            'remember_token' => Str::random(10),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'middle_name' => $this->faker->lastName(),
            'phone' => PhoneNumberValueObject::fromNative($this->faker->phoneNumber()),
            'otherphone' => PhoneNumberValueObject::fromNative($this->faker->phoneNumber()),
            'gender' => GenderEnum::getRandomInstance(),
            'attendant_category' => AttendantCategoryEnum::getRandomInstance(),
            'attendant_status' => AttendantStatusEnum::getRandomInstance(),
            'attendant_hired' => $this->faker->date,
            'birthday' => $this->faker->date,
            'mailingzip' => $this->faker->postcode(),
            'mailingstate' => $this->faker->text(20),
            'mailingcountry' => $this->faker->country(),
            'mailingcity' => $this->faker->city(),
            'mailingstreet' => $this->faker->streetAddress(),
            'otherzip' => $this->faker->postcode(),
            'otherstate' => $this->faker->text(50),
            'othercountry' => $this->faker->country(),
            'othercity' => $this->faker->city(),
            'otherstreet' => $this->faker->streetAddress(),
            'metro_station' => $this->faker->streetAddress(),
            'car_model' => $this->faker->company(),
            'car_year' => $this->faker->year(),
            'car_color' => $this->faker->colorName(),
            'resume' => $this->faker->text,
            'payment_data' => $this->faker->text,
            'crmid' => CrmIdValueObject::fromNative(
                $this->faker->randomNumber(2) . 'x' . $this->faker->randomNumber(3)
            ),
            'assigned_user_id' => CrmIdValueObject::fromNative('19x1'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
