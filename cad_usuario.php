<?php
include('config.php');

$usuario_sucess = ''; // Variável para armazenar mensagem sucesso de criação de usuário
$usuario_error = ''; // Variável para armazenar mensagem erro de criação de usuário

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    //$rashed_password = password_hash($senha, PASSWORD_DEFAULT); // Para criptografar a senha

    // Inserindo os dados no BD
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";

    // Prepara a consulta sql de forma segura
    $stmt = $mysqli->prepare($sql);

    //Garante que os dados sejam tratados de forma correta e segura
    $stmt->bind_param("sss", $nome, $email, $senha);

    //Executa a consulta sql e retorna msg de sucesso ou erro
    if ($stmt->execute()) {
        $usuario_sucess = "Usuário criado com sucesso!";
    } else {
        $usuario_error = "Erro: " . $sql . "<br>" . $mysqli->error;
    }

    // Fecha declaração
    $stmt->close();
}
// Fecha Bd
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonte Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Icones do Material Design -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Chamando CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <title>Registre-se</title>
</head>

<body>
    <div class="main-login">
        <form action="" method="post">
            <div class="card-login">
                <h1>Registre-se</h1>
                <div class="textfield">
                    <label for="">Nome Completo</label>
                    <input type="text" name="nome" id="idnome" required>
                </div>
                <div class="textfield">
                    <label for="">E-mail</label>
                    <input type="email" name="email" id="idemail" required>
                </div>
                <div class="textfield">
                    <label for="">Senha</label>
                    <input type="password" name="senha" id="idsenha" required>
                </div>
                <button class="btn-login" type="submit">Cadastrar</button>
                <span class="error"><?php echo $usuario_error; ?></span> <!-- Exibe a mensagem de erro de usuario -->
                <span class="sucess"><?php echo $usuario_sucess; ?></span> <!-- Exibe a mensagem de sucesso cadastro do usuário -->

                <p>Já tem uma conta? Faça login <a href="index.php">aqui</a></p>
            </div>
        </form>
    </div>
</body>

</html>