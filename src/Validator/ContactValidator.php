<?php
namespace App\Validator;

class ContactValidator
{
    private static $nameMinLength = 3;
    private static $nameMaxLength = 100;
    private static $emailMinLength = 5;
    private static $emailMaxLength = 100;
    private static $messageMinLength = 3;
    private static $messageMaxLength = 500;

    public function validate($params) {
        $name = $params['name'] ?? null;
        $email = $params['email'] ?? null;
        $message = $params['message'] ?? null;

        $errors = [];

        if (empty($name) === true) {
            $errors['name'] = 'Name is required';
        } else {
            $nameLength = strlen($name);

            if ($nameLength < self::$nameMinLength || $nameLength > self::$nameMaxLength) {
                $errors['name'] = "Name must be between " . self::$nameMinLength .
                                  " and " . self::$nameMaxLength . " characters";
            }
        }

        if (empty($email) === true) {
            $errors['email'] = 'Email is required';
        } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === true) {
            $errors['email'] = 'Email address used is invalid';
        } else {
            $emailLength = strlen($email);

            if ($emailLength < self::$emailMinLength || $emailLength > self::$emailMaxLength) {
                $errors['email'] = "Email must be between " . self::$emailMinLength .
                                   " and " . self::$emailMaxLength . "  characters";
            }
        }

        if (empty($message) === true) {
            $errors['message'] = 'Message is required';
        } else {
            $nameLength = strlen($name);

            if ($nameLength < self::$nameMinLength || $nameLength > self::$nameMaxLength) {
                $errors['name'] = "Name must be between " . self::$nameMinLength .
                                  " and " . self::$nameMaxLength . " characters";
            }
        }

        return empty($errors) === false ? $errors : true;
    }
}
