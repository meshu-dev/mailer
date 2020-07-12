<?php
namespace App\Service;

use App\Service\MailService;
use App\Service\CaptchaService;

/**
 * Sends e-mails for contact us forms.
 */
class ContactService
{
    /**
     * @var MailService
     */
    protected $mailService;
    
    /**
     * @var CaptchaService
     */
    protected $captchaService;
    
    /**
     * @var string
     */
    protected $fromEmail;
    
    /**
     * @var string
     */
    protected $fromName;

    /**
     * @param MailService $mailService Mailer service
     * @param CaptchaService $captchaService Captcha service
     * @param string $fromEmail Sender e-mail address
     * @param string $fromName Sender name
     */
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

    /**
     * Sends contact us e-mail message.
     *
     * @param string $subject The e-mail subject
     * @param string $toEmail The to e-mail address
     * @param string $message The e-mail message
     * @param string $captchaToken The captcha token
     *
     * @return bool Indicates if the e-mail was sent
     */
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
