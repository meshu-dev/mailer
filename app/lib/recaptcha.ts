const isTokenValid = async (token: string) => {
  let url = process.env.GOOGLE_RECAPTCHA_URL;
  url = `${url}?secret=${process.env.GOOGLE_SECRET_KEY}&response=${token}`;

  const response = await fetch(url);
  const data     = await response.json();

  return data ? data.success : false;
}

const Recaptcha = {
  isTokenValid
};

export default Recaptcha;
