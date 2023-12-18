import { NextResponse } from 'next/server';
import type { NextRequest } from 'next/server';
import Mailer from '../../lib/mailer';
import Recaptcha from '../../lib/recaptcha';
import { render } from '@react-email/render';
import ContactEmail from '../../components/Email/ContactEmail';
import { headers } from 'next/headers';

export interface RequestParams {
  token: string,
  name: string,
  email: string,
  message: string
}

const getOrigin = (): string | null => {
  const headersList = headers();
  const origin: string | null = headersList.get('origin');

  if (origin) {
    const validOriginsStr: string = String(process.env.ORIGIN_URLS);
    const validOrigins: string[]  = validOriginsStr.split(',');
  
    for (const validOrigin of validOrigins) {
      if (origin === validOrigin) {
        return validOrigin;
      }
    }
  }
  return null;
}

const getHeaders = () => {
  return {
    'Access-Control-Allow-Origin': getOrigin() || '',
    'Access-Control-Allow-Methods': 'POST, OPTIONS',
    'Access-Control-Allow-Headers': 'Content-Type'
  }
}

export const OPTIONS = async (request: NextRequest) => {
  return NextResponse.json(
    {},
    {
      status: 200,
      headers: getHeaders()
    }
  )
}

export async function POST(request: NextRequest) {
  console.log('Contact API - Request received', request);

  const headersList = headers()
  console.log('headersList', headersList);

  const origin = headersList.get('origin')
  console.log('origin', origin, process.env.ORIGIN_URLS);

  console.log('findOrigin', getOrigin());

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
    {
      status: 200,
      headers: getHeaders()
    }
  )
}
