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

        $mailer = $this->container->get('mailer');

        $subject = getenv('MAIL_SUBJECT');
        $fromEmail = getenv('MAIL_SENDER_EMAIL');
        $fromName = getenv('MAIL_SENDER_NAME');
        $toEmail = getenv('MAIL_RECEIVER_EMAIL');

        $mailMessage = $this->container->get('mailMessage');
        $mailMessage->setSubject($subject)
                    ->setFrom([$fromEmail => $fromName])
                    ->setTo([$toEmail])
                    ->setBody($message);

        $result = $mailer->send($mailMessage);

        $response->getBody()->write(
            json_encode(['isSent' => $result ? true : false])
        );
        return $response;
    }
}