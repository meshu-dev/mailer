<?php
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'mailer' => function (ContainerInterface $c) {
            $transport = new Swift_SmtpTransport(
                getenv('SWIFT_SMTP_HOST'),
                getenv('SWIFT_SMTP_PORT'),
                getenv('SWIFT_SMTP_ENCRYPTION')
            );
            $transport->setUsername(getenv('SWIFT_SMTP_USERNAME'));
            $transport->setPassword(getenv('SWIFT_SMTP_PASSWORD'));

            return new Swift_Mailer($transport);
        },
        'mailMessage' => function (ContainerInterface $c) {
            return new Swift_Message();
        }
    ]);
};
