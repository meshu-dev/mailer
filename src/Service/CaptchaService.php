<?php
namespace App\Service;

/**
 * Used for captcha services.
 */
class CaptchaService
{
    /**
     * @var object
     */
    protected $httpClient;
    
    /**
     * @var string
     */
    protected $captchaSecretKey;

    /**
     * @param object $httpClient HTTP Client to make requests
     * @param string $captchaSecretKey Captcha secret key
     */
    public function __construct(
        $httpClient,
        $captchaSecretKey
    ) {
        $this->httpClient = $httpClient;
        $this->captchaSecretKey = $captchaSecretKey;
    }

    /**
     * Verify the passed in captcha token.
     *
     * @param string $token The token
     *
     * @return bool Validation result
     */
    public function verifyToken($token): bool
    {
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
