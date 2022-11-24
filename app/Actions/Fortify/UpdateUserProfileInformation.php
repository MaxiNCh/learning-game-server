<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'login' => [
                'required',
                'string',
                'max:100',
                // Rule::unique(User::class),
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Rule::unique('users')->ignore($user->id),
            ],
            'rule' => [
                'nullable',
                Rule::in(['student', 'teacher']),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
        ])->validateWithBag('updateProfileInformation');

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'login' => $input['login'],
                'email' => $input['email'],
                'name' => $input['name'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'login' => $input['login'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
