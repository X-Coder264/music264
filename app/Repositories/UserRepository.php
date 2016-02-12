<?php
namespace Artsenal\Repositories;

use Artsenal\User;

class UserRepository {
    public function findByUserNameOrCreate($userData) {
        $user = User::where('provider_id', '=', $userData->id)->first();
        if(!$user) {
            $user = User::create([
                'provider_id' => $userData->id,
                'name' => $userData->name,
                'email' => $userData->email,
                'role_id' => 1,
            ]);
        }

        $this->checkIfUserNeedsUpdating($userData, $user);
        return $user;
    }

    public function checkIfUserNeedsUpdating($userData, $user) {

        $socialData = [
            'email' => $userData->email,
            'name' => $userData->name,
        ];
        $dbData = [
            'email' => $user->email,
            'name' => $user->name,
        ];

        if (!empty(array_diff($socialData, $dbData))) {
            $user->email = $userData->email;
            $user->name = $userData->name;
            $user->save();
        }
    }
}