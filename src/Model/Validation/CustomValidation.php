<?php

namespace App\Model\Validation;
use Cake\Validation\Validation;

/**
 * カスタムバリデーション
 */
class CustomValidation extends Validation {

    public static function tel($check)
    {
        return (bool) preg_match('/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/', $check);
    }

    public static function zip($check)
    {
        return (bool) preg_match('/^\d{3}\-\d{4}$/', $check);
    }

    public static function alphaNumDash($check)
    {
        return (bool) preg_match('/^[0-9a-z-_]+$/', $check);
    }
}