<?php
namespace Fsociety\Core;

use App, Validator;
use Illuminate\Support\ViewErrorBag;

class FormModel
{
    protected $inputData;
    protected $validationRules;
    /**
     * @var Validator
     */
    protected $validator;

    public function __construct()
    {
        $this->inputData = App::make('request')->all();
    }

    /**
     * @return array
     */
    public function getInputData() {
        return $this->inputData;
    }

    /**
     * @return bool
     * @throws NoValidationRulesFoundException
     */
    public function isValid() {
        $this->beforeValidation();
        if(!isset($this->validationRules)){
            throw new NoValidationRulesFoundException('No validation rules found in class' . get_called_class());
        }
        $this->validator = Validator::make($this->getInputData(), $this->getPreparedRules());
        return $this->validator->passes();
    }

    /**
     * @return ViewErrorBag
     */
    public function getErrors() {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->validator->errors();
    }

    /**
     * @return array
     */
    protected function getPreparedRules() {
        return $this->validationRules;
    }

    /**
     *
     */
    protected function beforeValidation() {
    }
}