<?php
namespace App\Controller;

use Psr\Container\ContainerInterface;

class MailController
{
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function send($request, $response, $args) {
        $params = $request->getParsedBody();

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

        $response->getBody()->write(
            json_encode(['isSent' => $isSent])
        );
        return $response;
    }
}
