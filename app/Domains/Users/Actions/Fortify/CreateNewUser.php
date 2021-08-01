<?php

declare(strict_types=1);

namespace Domains\Users\Actions\Fortify;

use Domains\Users\Models\User;
use Domains\Users\ValueObjects\FullNameValueObject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Parents\ValueObjects\PhoneNumberValueObject;

final class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return User
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['nullable', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'phone:RU'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return User::create([
            'name' => FullNameValueObject::fromNative($input['firstname'], $input['lastname'], $input['middle_name']),
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'middle_name' => $input['middle_name'],
            'phone' => PhoneNumberValueObject::fromNative($input['phone']),
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
