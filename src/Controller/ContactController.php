<?php
namespace App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Used for contact us forms to send e-mails to recipients.
 */
class ContactController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container Container used for DI
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Used contact details to send e-mail to receiver.
     *
     * @param Request $request The request object
     * @param Response $response The response object
     * @param array $args The request parameters
     *
     * * @return Response The response object
     */
    public function send(Request $request, Response $response, array $args): Response
    {
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
