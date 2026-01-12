<?php
/**
 * @package Scl_Traffic_Control
 * @version 1.0
 * Lógica de camuflagem integrada em arquivo único.
 */

// 1. Identificação do IP e Localização
function get_visitor_country() {
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Headers para servidores atrás de Proxy/Cloudflare
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];

    // Consulta silenciosa de Geocalização
    $ctx = stream_context_create(['http' => ['timeout' => 2]]); // Timeout curto para não travar o carregamento
    $api_url = "http://ip-api.com/json/{$ip}?fields=countryCode";
    $response = @file_get_contents($api_url, false, $ctx);
    $data = json_decode($response);

    return ($data && isset($data->countryCode)) ? $data->countryCode : 'US';
}

// 2. Execução do Filtro
if (get_visitor_country() === 'BR') {
    // Se for Brasil, redireciona instantaneamente antes de carregar o HTML
    header("Location: https://instagram.com/", true, 302);
    exit;
}

// 3. Se for estrangeiro (ou bot), exibe a White Page abaixo:
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <title>Airsoft Tactical - Blog de Treinamento e Equipamentos</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0; background: #f0f0f0; color: #333; }
        .nav { background: #2c3e50; color: #fff; padding: 15px 10%; display: flex; justify-content: space-between; align-items: center; }
        .hero { background: #34495e; color: white; padding: 60px 10%; text-align: center; }
        .content { padding: 40px 10%; max-width: 900px; margin: auto; background: #fff; line-height: 1.8; }
        .post-title { color: #27ae60; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .footer { background: #222; color: #777; text-align: center; padding: 30px; font-size: 0.8rem; }
        .badge { background: #27ae60; color: #fff; padding: 5px 10px; border-radius: 3px; font-size: 0.7rem; }
    </style>
</head>
<body>

<div class="nav">
    <strong>AIRSOFT TACTICAL</strong>
    <small>Início | Reviews | Legislação | Contato</small>
</div>

<div class="hero">
    <h1>Domine o Campo de Operações</h1>
    <p>Dicas técnicas para operadores iniciantes e veteranos.</p>
</div>

<div class="content">
    <h2 class="post-title">Como escolher sua primeira AEG</h2>
    <p><span class="badge">DICAS</span> Postado em 12 de Janeiro de 2026</p>
    <p>A escolha do seu primeiro equipamento de Airsoft é um marco na carreira de qualquer operador. Existem três pilares fundamentais que você deve considerar antes de investir: <strong>autonomia da bateria</strong>, <strong>disponibilidade de peças de reposição</strong> e o <strong>peso do equipamento</strong> em jogos de longa duração.</p>
    
    <p>Modelos baseados na plataforma M4A1 costumam ser os mais indicados devido à facilidade de upgrade, enquanto modelos AK-47 oferecem uma robustez externa superior para jogos em ambientes de mata densa.</p>
    
    <h3>Segurança em Primeiro Lugar</h3>
    <p>Nunca se esqueça: o uso de óculos de proteção com certificação ANSI Z87.1 é obrigatório. No Airsoft, a integridade física é a prioridade zero antes de qualquer disparo.</p>
</div>

<div class="footer">
    &copy; 2026 Airsoft Tactical Blog - O maior portal de simulação militar da América Latina.
</div>

</body>
</html>
