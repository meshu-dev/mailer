<?php
namespace App\Validator;

/**
 * Validates contact e-mail data.
 */
class ContactValidator
{
    /**
     * @var int
     */
    private static $nameMinLength = 3;
    
    /**
     * @var int
     */
    private static $nameMaxLength = 100;
    
    /**
     * @var int
     */
    private static $emailMinLength = 5;
    
    /**
     * @var int
     */
    private static $emailMaxLength = 100;
    
    /**
     * @var int
     */
    private static $messageMinLength = 3;
    
    /**
     * @var int
     */
    private static $messageMaxLength = 500;

    /**
     * Validate the passed in parameters.
     *
     * @param array $params The parameters
     *
     * * @return array|bool The validation errors or true
     */
    public function validate($params)
    {
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
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === true) {
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
