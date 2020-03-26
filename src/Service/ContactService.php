<?php
namespace App\Service;

use App\Service\MailService;
use App\Service\CaptchaService;

class ContactService
{
    protected $mailService;
    protected $captchaService;
    protected $fromEmail;
    protected $fromName;

    public function __construct(
        MailService $mailService,
        CaptchaService $captchaService,
        $fromEmail,
        $fromName
    ) {
        $this->mailService = $mailService;
        $this->captchaService = $captchaService;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }

    public function sendEmail(
        $subject,
        $toEmail,
        $message,
        $captchaToken
    ) {
        $isTokenValid = $this->captchaService->verifyToken($captchaToken);

        if ($isTokenValid === true) {
            $result = $this->mailService->send(
                $subject,
                $this->fromEmail,
                $this->fromName,
                $toEmail,
                $message
            );
            $isSent = $result;
        } else {
            $isSent = false;
        }
        return $isSent;
    }
}