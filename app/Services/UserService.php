<?php
namespace Fsociety\Services;

use Fsociety\Models\User;

class UserService
{
    /**
     * Create a user
     * @param array $data
     * @return User
     */
    public function createUser(array $data) {
        return User::create([
            'nick' => $data['nick'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}