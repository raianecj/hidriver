<?php
// Include do arquivo de configuração e verificação de login
include('protect.php');
include('config.php');

// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os dados do formulário foram enviados
    if (isset($_POST['id']) && isset($_POST['modelo']) && isset($_POST['marca']) && isset($_POST['ano'])) {
        // Obtém os dados do formulário
        $id = $_POST['id'];
        $modelo = $_POST['modelo'];
        $marca = $_POST['marca'];
        $ano = $_POST['ano'];

        // Consulta SQL para atualizar o veículo no banco de dados
        $sql = "UPDATE veiculos SET modelo = ?, marca = ?, ano = ? WHERE id = ?";

        // Prepara a consulta SQL
        $stmt = $mysqli->prepare($sql);

        // Verifica se a preparação da consulta foi bem-sucedida
        if ($stmt) {
            // Vincula os parâmetros à consulta
            $stmt->bind_param("sssi", $modelo, $marca, $ano, $id);

            // Executa a consulta
            if ($stmt->execute()) {
                // Redireciona de volta para a página de veículos após a atualização
                header("Location: veiculos.php?success=true");
                exit();
            } else {
                echo "Erro ao atualizar o veículo: " . $stmt->error;
            }

            // Fecha a declaração
            $stmt->close();
        } else {
            echo "Erro na preparação da consulta: " . $mysqli->error;
        }
    } else {
        echo "Todos os campos do formulário devem ser preenchidos.";
    }
} else {
    echo "Acesso inválido à página de atualização de veículo.";
}

// Fecha a conexão
$mysqli->close();
?>
