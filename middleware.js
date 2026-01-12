import { next } from '@vercel/edge';

export const config = {
  matcher: '/', // Aplica o filtro na página inicial
};

export default function middleware(req) {
  // Captura o país através do header da Vercel (Geolocalização nativa)
  const country = req.geo?.country || 'US';

  // Se o IP for do Brasil (BR)
  if (country === 'BR') {
    return Response.redirect('https://instagram.com/', 302);
  }

  // Se for gringo ou bot, continua para o index.html (White Page)
  return next();
}