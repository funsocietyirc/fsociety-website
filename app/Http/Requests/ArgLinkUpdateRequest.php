<?php
namespace Fsociety\Http\Requests;

use Fsociety\Models\ArgTracking;

class ArgLinkUpdateRequest extends Request
{
    public function authorize()
    {
        $arg = ArgTracking::whereUrl($this->input('url'))->first();
        return $arg && $this->user()->can('update', $arg);
    }

    protected $rulesArray = [
        'name' => 'required|max:255',
        'url' => 'required|url',
        'description' => 'max:500'
    ];
}