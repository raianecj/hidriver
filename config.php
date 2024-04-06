<!-- ----------Criando Conexão com o BD --------- -->
<?php 
$usuario = 'root';
$senha = '';
$database = 'hidriver';
$host = 'localhost';

$mysqli = new mysqli($host, $usuario, $senha, $database);

if($mysqli -> error) {
    die ("Falha ao conectar ao banco de dados: " . $mysqli->error);
}
?>