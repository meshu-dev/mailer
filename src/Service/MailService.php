<?php
namespace App\Service;

class MailService
{
    protected $mailer;
    protected $mailMessage;

    public function __construct(
        $mailer,
        $mailMessage
    ) {
        $this->mailer = $mailer;
        $this->mailMessage = $mailMessage;
    }

    public function send(
        $subject,
        $fromEmail,
        $fromName,
        $toEmail,
        $message
    ) {
        $this->mailMessage
            ->setSubject($subject)
            ->setFrom([$fromEmail => $fromName])
            ->setTo([$toEmail])
            ->setBody($message);

        $result = $this->mailer->send($this->mailMessage);

        return $result ? true : false;
    }
}
