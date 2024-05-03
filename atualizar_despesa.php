<?php
// Include do arquivo de configuração e verificação de login
include('protect.php');
include('config.php');

// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os dados do formulário foram enviados
    if (isset($_POST['id']) && isset($_POST['veiculo']) && isset($_POST['tipo_despesa']) && isset($_POST['descricao']) && isset($_POST['valor'])) {
        // Obtém os dados do formulário
        $id = $_POST['id'];
        $veiculo = $_POST['veiculo'];
        $tipo_despesa = $_POST['tipo_despesa'];
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];

        // Consulta SQL para atualizar a despesa no banco de dados
        $sql = "UPDATE despesas SET id_veiculo = ?, tipo_despesa = ?, descricao = ?, valor = ? WHERE id = ?";


        // Prepara a consulta SQL
        $stmt = $mysqli->prepare($sql);

        // Verifica se a preparação da consulta foi bem-sucedida
        if ($stmt) {
            // Vincula os parâmetros à consulta
            $stmt->bind_param("ssssi", $veiculo, $tipo_despesa, $descricao, $valor, $id);

            // Executa a consulta
            if ($stmt->execute()) {
                // Redireciona de volta para a página de despesas após a atualização
                header("Location: painel.php?success=true");
                exit();
            } else {
                echo "Erro ao atualizar a despesa: " . $stmt->error;
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
    echo "Acesso inválido à página de atualização de despesa.";
}

// Fecha a conexão
$mysqli->close();
?>
