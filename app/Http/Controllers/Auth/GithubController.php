<?php
namespace Fsociety\Http\Controllers\Auth;

use Fsociety\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Socialite;

class GithubController extends Controller {

    /**
     * Redirect user to the GitHub Authentication page.
     * @return Response
     */
    public function redirectToProvider() {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain user information from Github
     * @param Request $request
     * @return Response
     */
    public function handleProviderCallback(Request $request) {
        $user = Socialite::driver('github')->user();
        dd($user);
    }


}