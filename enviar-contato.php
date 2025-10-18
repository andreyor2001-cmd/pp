<?php
// Configurações básicas
$destinatario = "contato@planejareprogramar.com.br";
$assunto_site = "Nova mensagem do site Planejar e Programar";

// Captura e sanitiza os dados do formulário
$nome = htmlspecialchars(trim($_POST['nome'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$telefone = htmlspecialchars(trim($_POST['telefone'] ?? ''));
$assunto = htmlspecialchars(trim($_POST['assunto'] ?? ''));
$mensagem = htmlspecialchars(trim($_POST['mensagem'] ?? ''));

// Validação simples
if (empty($nome) || empty($email) || empty($mensagem)) {
    http_response_code(400);
    echo "Por favor, preencha todos os campos obrigatórios.";
    exit;
}

// Monta o corpo do e-mail em HTML
$corpo = "
<html>
<body style='font-family: Arial, sans-serif;'>
  <h2>Nova mensagem recebida pelo site Planejar e Programar</h2>
  <p><strong>Nome:</strong> {$nome}</p>
  <p><strong>E-mail:</strong> {$email}</p>
  <p><strong>Telefone:</strong> {$telefone}</p>
  <p><strong>Assunto:</strong> {$assunto}</p>
  <p><strong>Mensagem:</strong><br>{$mensagem}</p>
  <hr>
  <p style='font-size:12px;color:#555;'>Mensagem enviada automaticamente pelo formulário de contato.</p>
</body>
</html>
";

// Cabeçalhos do e-mail
$headers  = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: {$nome} <{$email}>" . "\r\n";
$headers .= "Reply-To: {$email}" . "\r\n";

// Envia o e-mail
if (mail($destinatario, $assunto_site, $corpo, $headers)) {
    echo "<script>alert('Mensagem enviada com sucesso! Em breve entraremos em contato.');window.location.href='contato.html';</script>";
} else {
    echo "<script>alert('Ocorreu um erro ao enviar sua mensagem. Tente novamente.');history.back();</script>";
}
?>
