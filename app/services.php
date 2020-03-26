<?php
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerInterface $container) {
	$container->set('MailService', function (ContainerInterface $innerContainer) {
	    $mailer = $innerContainer->get('mailer');
	    $mailMessage = $innerContainer->get('mailMessage');

	    return new \App\Service\MailService($mailer, $mailMessage);
	});
	$container->set('CaptchaService', function (ContainerInterface $innerContainer) {
	    $googleCaptchaUrl = getenv('GOOGLE_CAPTCHA_URL');
	    $googleCaptchaSecretKey = getenv('GOOGLE_CAPTCHA_SECRET_KEY');

	    return new \App\Service\CaptchaService(
	    	new \GuzzleHttp\Client(['base_uri' => $googleCaptchaUrl]),
	    	$googleCaptchaSecretKey
	    );
	});
	$container->set('ContactService', function (ContainerInterface $innerContainer) {
	    $mailService = $innerContainer->get('MailService');
	    $captchaService = $innerContainer->get('CaptchaService');
        $fromEmail = getenv('MAIL_SENDER_EMAIL');
        $fromName = getenv('MAIL_SENDER_NAME');

	    return new \App\Service\ContactService(
	    	$mailService,
	    	$captchaService,
	    	$fromEmail,
	    	$fromName
	    );
	});
};
