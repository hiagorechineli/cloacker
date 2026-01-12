<?php
$ip_visitante = $_SERVER['REMOTE_ADDR'];

$ip_visitante = $_SERVER['HTTP_CF_CONNECTING_IP'];

try {
    // Consulta a API de Geolocalização (timeout de 2 segundos para não travar o site)
    $ctx = stream_context_create(['http' => ['timeout' => 2]]);
    $api_url = "http://ip-api.com/json/{$ip_visitante}";
    $resposta = @file_get_contents($api_url, false, $ctx);
    
    if ($resposta) {
        $dados = json_decode($resposta);

        if ($dados && $dados->status === 'success') {
            $pais = $dados->countryCode;

            if ($pais === 'US') {
                // REDIRECIONA AMERICANOS PARA WHITEPAGE
                header("Location: https://blog.ventureshop.com.br/");
                exit;
            } 
            elseif ($pais === 'BR') {
                // REDIRECIONA BRASILEIROS PARA BLACKPAGE
                header("Location: https://revolver-one.vercel.app/");
                exit;
            }
        }
    }
} catch (Exception $e) {
    // Em caso de erro na API, você pode definir um destino padrão
}

// Destino caso o IP não seja nem BR nem US ou a API falhe
echo "Acesso não permitido para sua região.";

?>
