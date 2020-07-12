<?php
namespace App\Service;

/**
 * Prepares and sends e-mails.
 */
class MailService
{
    /**
     * @var object
     */
    protected $mailer;
    
    /**
     * @var object
     */
    protected $mailMessage;

    /**
     * @param object $mailer Mailer object
     * @param object $mailMessage Mail message object
     */
    public function __construct(
        $mailer,
        $mailMessage
    ) {
        $this->mailer = $mailer;
        $this->mailMessage = $mailMessage;
    }

    /**
     * Verify the passed in captcha token.
     *
     * @param string $subject The e-mail subject
     * @param string $fromEmail The from e-mail address
     * @param string $fromName The from name
     * @param string $toEmail The to e-mail address
     * @param string $message The e-mail message
     *
     * @return bool Indicates if the e-mail was sent
     */
    public function send(
        $subject,
        $fromEmail,
        $fromName,
        $toEmail,
        $message
    ): bool {
        $this->mailMessage
            ->setSubject($subject)
            ->setFrom([$fromEmail => $fromName])
            ->setTo([$toEmail])
            ->setBody($message);

        $result = $this->mailer->send($this->mailMessage);

        return $result ? true : false;
    }
}
