<?php

namespace Fsociety\Http\Requests;

use Auth;

class ArgLinkStoreRequest extends Request
{
    protected $rulesArray = [
        'name' => 'required|max:255',
        'url' => 'required|url|unique:arg_tracking',
        'description' => 'max:500'
    ];

    /**
     * User is able to make this request
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

}
