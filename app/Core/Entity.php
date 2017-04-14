<?php

namespace Fsociety\Core;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ViewErrorBag;
use Validator;

/**
 * Fsociety\Core\Entity
 *
 * @mixin \Eloquent
 */
class Entity extends Model
{
    protected $validationRules = [];
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @return bool
     * @throws NoValidationRulesFoundException
     */
    public function isValid() {
        if(!isset($this->validationRules)) {
            throw new NoValidationRulesFoundException('No validation rules array defined for class' . get_called_class());
        }
        $this->validator = Validator::make($this->getAttributes(), $this->getPreparedRules());
        return $this->validator->passes();
    }

    /**
     * @return ViewErrorBag
     * @throws NoValidatorInstantiatedException
     */
    public function getErrors() {
        if (!$this->validator) {
            throw new NoValidatorInstantiatedException;
        }
        return $this->validator->errors();
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = []) {
        if (!$this->isValid()) {
            return false;
        }
        return parent::save($options);
    }

    /**
     * @return array
     */
    public function getPreparedRules() {
        return $this->replaceIdIfExists($this->validationRules);
    }

    /**
     * @param array $rules
     * @return array
     */
    public function replaceIdIfExists(array $rules) {
        $newRules = [];
        foreach($rules as $key => $rule) {
            if(str_contains($rule, '<id>')) {
                $replacement = $this->exists ? $this->getAttribute($this->primaryKey) : '';
                $rule = str_replace('<id>', $replacement, $rule);
            }
            array_set($newRules, $key, $rule);
        }
        return $newRules;
    }
}