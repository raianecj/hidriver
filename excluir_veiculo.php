<?php 
include('config.php');

// ID do veículo a ser excluído
$id = $_GET['id'];

// Prepara a query SQL para excluir o veículo com o ID especificado
$sql = "DELETE FROM veiculos WHERE id=$id";

// Executa a query SQL
if ($mysqli->query($sql) === TRUE) {
    // Redireciona de volta para a página de lista de veículos após excluir o veículo
    header("Location: veiculos.php");
    exit(); // Termina o script após redirecionar
} else {
    echo "Erro ao excluir veículo: " . $mysqli->error;
}

// Fecha a conexão com o banco de dados
$mysqli->close();



?>