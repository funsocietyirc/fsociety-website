<?php

namespace Fsociety\Http\Controllers\Auth;

use Fsociety\Http\Controllers\Controller;
use Fsociety\Models\User;
use Fsociety\Services\UserService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $userService;

    /**
     * Create a new controller instance.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('guest');
        $this->userService = $userService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $valOptions = [
            'nick' => 'required|max:255|unique:users',
            'email' => 'email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        if(config('app.env') != 'local') {
            dd(config('app.env'));
            array_merge($valOptions, ['g-recaptcha-response' => 'required|captcha']);
        }
        $results = Validator::make($data,$valOptions);
        return $results;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return $this->userService->createUser($data);
    }
}
