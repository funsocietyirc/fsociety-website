<?php
namespace Fsociety\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    protected $rulesArray;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->sanitize();
        return $this->rulesArray;
    }

    /**
     * Sanitize user input
     */
    public function sanitize()
    {
        $input = $this->all();

        if (preg_match("#https?://#", $input['url']) === 0) {
            $input['url'] = 'http://'.$input['url'];
        }

        $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $input['description'] = filter_var($input['description'],
            FILTER_SANITIZE_STRING);

        $this->replace($input);
    }
}