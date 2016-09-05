<?php
namespace Fsociety\Http\Requests;

use Auth;

class ArgLinkConnectionRequest extends Request
{

    protected $rulesArray = [
        'episode'   =>  'required|exists:episodes,id'
    ];

    public function authorize() {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rulesArray;
    }
}