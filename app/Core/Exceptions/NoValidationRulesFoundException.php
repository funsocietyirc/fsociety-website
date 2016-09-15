<?php
/**
 * Created by PhpStorm.
 * User: irony
 * Date: 9/15/16
 * Time: 7:09 PM
 */

namespace Fsociety\Core;


class NoValidationRulesFoundException extends \Exception
{

    /**
     * NoValidationRulesFoundException constructor.
     * @param string $string
     */
    public function __construct($string)
    {
    }
}