<?php
session_start(); // Inicia a sessão
include('config.php');

//isset - se existir email ou senha {}
//strlen - quantidade de caracteres
//leitura do código: Se existir email ou senha então se a quantidade de caracteres de email igual a 0 "", senao se a quantidade de caracteres da senha for igual a 0 ""

$email_error = ''; // Variável para armazenar mensagem de erro de e-mail
$senha_error = ''; // Variável para armazenar mensagem de erro de senha
$login_error = ''; // Variável para armazenar mensagem de erro de email e senha incorretos

if (isset($_POST['email']) || isset($_POST['senha'])) {
    if (strlen($_POST['email']) == 0) {
        $email_error = "Preencha seu e-mail";
    } else if (strlen($_POST['senha']) == 0) {
        $senha_error = "Preencha sua senha";
    } else {

        $email = $mysqli->real_escape_string($_POST['email']); //string de segurança contra hackers, que "limpa" o campo
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'"; //seleciona na tabela usuarios onde email e senha tem que ser igual aos da variavel
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        //verificar se a consulta retornou 1 registro encontrado
        $quantidade = $sql_query->num_rows;

        // echo "Número de resultados: " . $quantidade . "<br>";

        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

            // criando uma sessão


            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            //após autenticado com sucesso e criado uma sessão, é direcionado para a pagina principal
            header("Location: painel.php");
            exit(); // Certifica de sair após o redirecionamento para evitar execução adicional do código.

        } else {
            $login_error = "E-mail ou senha incorretos";
        }
        // Depuração detalhada
        // echo "Dados do usuário:<br>";
        // var_dump($usuario);
    }
}


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

    <title>Hi Driver</title>
</head>

<body>
    <div class="main-login">
        <form action="" method="post">
            <div class="card-login">
                <h1>Login</h1>
                <div class="textfield">
                    <label for="">E-mail</label>
                    <input type="email" name="email" id="idemail">
                    <span class="error"><?php echo $email_error; ?></span> <!-- Exibe a mensagem de erro de e-mail -->
                </div>
                <div class="textfield">
                    <label for="">Senha</label>
                    <input type="password" name="senha" id="idsenha">
                    <span class="error"><?php echo $senha_error; ?></span> <!-- Exibe a mensagem de erro de senha -->

                </div>
                <button class="btn-login" type="submit">Entrar</button>
                <span class="error"><?php echo $login_error; ?></span> <!-- Exibe a mensagem de erro de login -->

                <p>Não tem uma conta? Registre-se <a href=cad_usuario.php>aqui</a></p>

            </div>
        </form>


    </div>
</body>

</html>