<?php
namespace App\Controller;

use Psr\Container\ContainerInterface;

class ContactController
{
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function send($request, $response, $args) {
        $params = $request->getParsedBody();

        $contactValidator = $this->container->get('ContactValidator');
        $result = $contactValidator->validate($params);

        if (isset($result['errors']) === false) {
            $name = $params['name'] ?? null;
            $email = $params['email'] ?? null;
            $message = $params['message'] ?? null;
            $captchaToken = $params['captchaToken'] ?? null;

            $subject = getenv('MAIL_SUBJECT');
            $toEmail = getenv('MAIL_RECEIVER_EMAIL');

            $contactService = $this->container->get('ContactService');
            $isSent = $contactService->sendEmail(
                $subject,
                $toEmail,
                $message,
                $captchaToken
            );
            $result = ['isSent' => $isSent];
        } else {
            $result = ['errors' => $result['errors']];
        }

        $response->getBody()->write(
            json_encode($result)
        );
        return $response;
    }
}
