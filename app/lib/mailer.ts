import nodemailer from 'nodemailer'
import SMTPTransport from 'nodemailer/lib/smtp-transport'

export interface SmtpServerParams {
  host?:     string,
  port?:     string,
  user?:     string,
  password?: string
}

export interface MailParams {
  from?:    string,
  to?:      string,
  subject?: string,
  html?:    string
}

const getSmtpTransporter = (params: SmtpServerParams): nodemailer.Transporter<SMTPTransport.SentMessageInfo> => {
  return nodemailer.createTransport({
    host: params.host,
    port: Number(params.port),
    secure: false, // true for 465, false for other ports
    auth: {
      user: params.user, //testAccount.user, // generated ethereal user
      pass: params.password, //testAccount.pass // generated ethereal password
    },
    tls: {
      ciphers:'SSLv3'
    }
  });
};

const sendMail = async (serverParams: SmtpServerParams, mailParams: MailParams): Promise<boolean> => {
  let transporter = getSmtpTransporter(serverParams);
  let info: SMTPTransport.SentMessageInfo = await transporter.sendMail(mailParams);

  let isEmailSend: boolean = false;

  if (info.accepted) {
    const receiverEmail: string = String(info.accepted[0]);
    isEmailSend = String(mailParams.to).includes(receiverEmail);
  }

  return isEmailSend;
}

const Mailer = {
  sendMail
};

export default Mailer;
