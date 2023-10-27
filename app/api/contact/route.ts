import { NextResponse } from 'next/server';
import type { NextRequest } from 'next/server';
import Mailer from '../../lib/mailer';
import Recaptcha from '../../lib/recaptcha';
import { render } from '@react-email/render';
import ContactEmail from '../../components/Email/ContactEmail';

export const dynamic = 'force-static';

export interface RequestParams {
  token: string,
  name: string,
  email: string,
  message: string
}

export function GET(request: NextRequest) {
  return NextResponse.json(
    {
      body: request.body,
      path: request.nextUrl.pathname,
      query: request.nextUrl.search,
      cookies: request.cookies.getAll(),
    },
    {
      status: 200,
    },
  );
}

export async function POST(request: NextRequest) {
  console.log('Contact API - Request received');

  const env = process.env.NODE_ENV;
  const body: RequestParams = await request.json();

  let sendEmail: boolean = false;
  let response: any = {};

  if (env === 'production') {
    sendEmail = await Recaptcha.isTokenValid(body.token);
  } else {
    sendEmail = true;
  }

	if (sendEmail) {
    const viewParams = {
      name: body.name,
      message: body.message
    };
  
    const isEmailSent = await Mailer.sendMail({
      host: process.env.MAILER_HOST,
      port: process.env.MAILER_PORT,
      user: process.env.MAILER_USERNAME,
      password: process.env.MAILER_PASSWORD
    },
    {
      from: `${body.name} <${body.email}>`,
      to: process.env.MAILER_TO,
      subject: process.env.MAILER_SUBJECT,
      html: render(ContactEmail(viewParams))
    });
  
    console.log('Contact API - Email Result', isEmailSent);

    response['success'] = isEmailSent;
  } else {
    response['success'] = false;
  }

  return NextResponse.json(
    response,
    { status: 200 }
  );
}
