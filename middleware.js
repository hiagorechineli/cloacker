export const config = {
  matcher: '/',
};

export default function middleware(req) {
  // A Vercel identifica o país pelo cabeçalho da requisição
  const country = req.headers.get('x-vercel-ip-country') || 'US';

  if (country === 'BR') {
    return Response.redirect('https://instagram.com/', 302);
  }
  // Se não for BR, ele deixa passar para o index.html
}
