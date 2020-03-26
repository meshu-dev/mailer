<?php
namespace App\Service;

class CaptchaService
{
    protected $httpClient;
    protected $captchaSecretKey;

    public function __construct(
        $httpClient,
        $captchaSecretKey
    ) {
        $this->httpClient = $httpClient;
        $this->captchaSecretKey = $captchaSecretKey;
    }

    public function verifyToken($token) {
        $response = $this->httpClient->post(
            '/recaptcha/api/siteverify',
            [
                'form_params' => [
                    'secret' => $this->captchaSecretKey,
                    'response' => $token
                ]
            ]
        );
        $body = $response->getBody();
        $result = $body->getContents();
        $jsonResult = json_decode($result, true);

        return empty($jsonResult['success']) === false ? true : false;
    }
}