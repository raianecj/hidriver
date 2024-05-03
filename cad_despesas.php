<?php
include('protect.php');
include('config.php');

$usuario = $_SESSION['nome'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processar o formulário de cadastro de despesas
    $veiculo = $_POST['veiculo'];
    $tipo_despesa = $_POST['tipo_despesa'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_despesa = $_POST['data_despesa'];

    // Validar e sanitizar os dados (não incluído neste exemplo)

    // Inserir as informações da despesa no banco de dados
    $sql = "INSERT INTO despesas (id_veiculo, tipo_despesa, descricao, valor, data_despesa) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("issss", $veiculo, $tipo_despesa, $descricao, $valor, $data_despesa);
    $stmt->execute();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hi Driver</title>

    <!-- Fonte Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Icones do Material Design -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Chamando CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- grid-conteiner: contêiner que envolve todo o conteúdo da página -->
    <div class="grid-container">
        <!-- Header: Seção de cabeçalho da página -->
        <header class="header">
            <div class="menu-icon" onclick="openSidebar()">
                <span class="material-icons-outlined">menu</span>
            </div>
            <div class="header-left">
                <span class="material-icons-outlined ">sentiment_satisfied_alt</span>
                <span class="user-name font-weight-bold "><?php echo "Hi $usuario"; ?></span>

            </div>
            <div class="header-right">
                <a href="logout.php"><span class="material-icons-outlined">logout</span> </a>
            </div>
        </header>
        <!-- End Header -->

        <!-- Sidebar: Barra lateral(Menu) que poder ser aberta e fechada -->
        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-logo">
                    <span class="material-icons-outlined">emoji_transportation</span> HI DRIVER
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>
            <ul class="sidebar-list">
                <li class="sidebar-list-item">
                    <a href="painel.php">
                        <span class="material-icons-outlined">dashboard</span> Painel Inicial
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="veiculos.php">
                        <span class="material-icons-outlined">drive_eta</span> Veículos
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="cad_despesas.php">
                        <span class="material-icons-outlined">fact_check</span> Despesas
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#">
                        <span class="material-icons-outlined">calendar_month</span> Agenda
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#">
                        <span class="material-icons-outlined">poll</span> Relatórios
                    </a>
                </li>
            </ul>
        </aside>
        <!-- End Sidebar -->

        <!-- Main: Conteúdo principal da página -->
        <main class="main-conteiner">
            <div class="main-title">
                <h2>CADASTRO DE DESPESAS</h2>
            </div>

            <div class="cad-desepesas">
                <form action="cad_despesas.php" method="post">
                    <div class="card-cad-despesas">
                        <div class="textfield">
                            <label for="veiculo">Veículo:</label>
                            <select name="veiculo" id="veiculo">
                                <!-- Opções de veículos do usuário -->
                                <?php

                                // Consulta SQL para selecionar os veículos do usuário
                                $sql = "SELECT id, modelo FROM veiculos WHERE id_usuario = ?";

                                // Prepara a consulta SQL de forma segura
                                $stmt = $mysqli->prepare($sql);

                                // Verifica se a preparação da consulta foi bem-sucedida
                                if ($stmt) {
                                    // Vincula o parâmetro ID do usuário
                                    $stmt->bind_param("i", $_SESSION['id']);

                                    // Executa a consulta
                                    $stmt->execute();

                                    // Obtém o resultado da consulta
                                    $result = $stmt->get_result();

                                    // Loop para exibir as opções do select
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['modelo'] . "</option>";
                                    }

                                    // Fecha a declaração
                                    $stmt->close();
                                } else {
                                    // Em caso de erro na preparação da consulta
                                    echo "<option value=''>Erro ao carregar veículos</option>";
                                }
                                ?>

                            </select>
                        </div>
                        <div class="textfield">
                            <label for="tipo">Tipo de Despesa:</label>
                            <select name="tipo_despesa" id="tipo_despesa">
                                <!-- Tipos de Despesass -->
                                <?php

                                // Consulta SQL para selecionar os tipos de despesa
                                $sql = "SELECT id, nome FROM tipo_despesa";

                                // Prepara a consulta SQL de forma segura
                                $stmt = $mysqli->prepare($sql);

                                // Verifica se a preparação da consulta foi bem-sucedida
                                if ($stmt) {
                                    // Executa a consulta
                                    $stmt->execute();

                                    // Obtém o resultado da consulta
                                    $result = $stmt->get_result();

                                    // Loop para exibir as opções do select
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                                    }

                                    // Fecha a declaração
                                    $stmt->close();
                                } else {
                                    // Em caso de erro na preparação da consulta
                                    echo "<option value=''>Erro ao carregar tipo de despesa</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="textfield">
                            <label for="descricao">Descrição:</label>
                            <input type="text" name="descricao" id="descricao" required>
                        </div>
                        <div class="textfield">
                            <label for="valor">Valor:</label>
                            <input type="text" name="valor" id="valor" required>
                        </div>
                        <div class="textfield">
                            <label for="data_despesa">Data:</label>
                            <input type="date" name="data_despesa" id="data_despesa" required>
                        </div>
                        <button class="btn-cad" type="submit">Cadastrar Despesa</button>
                    </div>
                </form>
            </div>
        </main>
        <!--End Main -->
    </div>
    <!-- End grid-conteiner -->
    <!-- Chamando JS -->
</body>

</html>