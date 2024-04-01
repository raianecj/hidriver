<!-- Inicia a sessão e protege a pagina de ser acessada por alguem que não esteja logado  -->
<?php 

session_start(); // Inicia a sessão

if(!isset($_SESSION['id'])){
    die ("Por favor, autentique-se aqui <p><a href=\"index.php\">Entrar</a></p>");
}


?>

