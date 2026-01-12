<?php
/**
 * Cloaker Simples com Geolocalização
 * 
 * Este script redireciona usuários com base no país de origem.
 * Se o arquivo estiver sendo baixado em vez de executado, verifique se o PHP está instalado
 * e se o módulo do servidor web (Apache/Nginx) está ativo.
 */

// 1. Obter o IP real do visitante (Suporte para Cloudflare e Proxy Direto)
function get_client_ip() {
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
    }
    return $_SERVER['REMOTE_ADDR'];
}

$ip_visitante = get_client_ip();

// 2. Lógica de Redirecionamento
try {
    // Timeout curto para não prejudicar a experiência do usuário
    $ctx = stream_context_create([
        'http' => [
            'timeout' => 3,
            'header'  => "User-Agent: PHP-Cloaker\r\n"
        ]
    ]);
    
    $api_url = "http://ip-api.com/json/{$ip_visitante}?fields=status,countryCode";
    $resposta = @file_get_contents($api_url, false, $ctx);
    
    if ($resposta) {
        $dados = json_decode($resposta);

        if ($dados && isset($dados->status) && $dados->status === 'success') {
            $pais = $dados->countryCode;

            if ($pais === 'US') {
                // REDIRECIONA AMERICANOS PARA WHITEPAGE
                header("Location: https://blog.ventureshop.com.br/", true, 302);
                exit;
            } 
            elseif ($pais === 'BR') {
                // REDIRECIONA BRASILEIROS PARA BLACKPAGE
                header("Location: https://revolver-one.vercel.app/", true, 302);
                exit;
            }
        }
    }
} catch (Exception $e) {
    // Log de erro silencioso ou tratamento padrão
}

// 3. Destino padrão (Caso falhe ou seja de outra região)
// Você pode mudar para um redirecionamento ou uma mensagem amigável
header("HTTP/1.1 403 Forbidden");
echo "Acesso não permitido para sua região.";
?>
