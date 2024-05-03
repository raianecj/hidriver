<?php
include('protect.php');
include('config.php');

$usuario = $_SESSION['nome'];

// Verifica se o ID da despesa foi fornecido via GET
if (isset($_GET['id'])) {
    // Obtém o ID da despesa da URL
    $id_despesa = $_GET['id'];

    // Consulta SQL para selecionar os dados da despesa com base no ID
    $sql = "SELECT id_veiculo, tipo_despesa, descricao, valor, data_despesa FROM despesas WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt) {
        // Vincula o parâmetro ID da despesa
        $stmt->bind_param("i", $id_despesa);

        // Executa a consulta
        $stmt->execute();

        // Vincula o resultado da consulta
        $stmt->bind_result($id_veiculo, $tipo_despesa, $descricao, $valor, $data_despesa);

        // Obtém os dados da despesa
        $stmt->fetch();

        // Fecha a declaração
        $stmt->close();
    } else {
        // Em caso de erro na preparação da consulta
        echo "Erro ao recuperar dados da despesa.";
    }
} else {
    // Se o ID da despesa não foi fornecido via GET, redireciona de volta para a página de despesas
    header("Location: cad_despesas.php");
    exit();
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
                <h2>EDITAR DESPESAS</h2>
            </div>

            <div class="cad-desepesas">
                <form action="atualizar_despesa.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id_despesa; ?>">
                    <div class="card-cad-despesas">
                        <!-- Preenchimento dos campos do formulário com os dados da despesa -->
                        <div class="textfield">
                            <label for="veiculo">Veículo:</label>
                            <select name="veiculo" id="veiculo">
                                <!-- Opções de veículos do usuário -->
                                <?php
                                // Consulta SQL para selecionar os veículos do usuário
                                $sql = "SELECT id, modelo FROM veiculos WHERE id_usuario = ?";
                                $stmt = $mysqli->prepare($sql);
                                if ($stmt) {
                                    $stmt->bind_param("i", $_SESSION['id']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $selected = ($row['id'] == $id_veiculo) ? "selected" : "";
                                        echo "<option value='" . $row['id'] . "' $selected>" . $row['modelo'] . "</option>";
                                    }
                                    $stmt->close();
                                } else {
                                    echo "<option value=''>Erro ao carregar veículos</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="textfield">
                            <label for="tipo">Tipo de Despesa:</label>
                            <select name="tipo_despesa" id="tipo_despesa">
                                <!-- Tipos de Despesas -->
                                <?php
                                // Consulta SQL para selecionar os tipos de despesa
                                $sql = "SELECT id, nome FROM tipo_despesa";
                                $stmt = $mysqli->prepare($sql);
                                if ($stmt) {
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $selected = ($row['id'] == $tipo_despesa) ? "selected" : "";
                                        echo "<option value='" . $row['id'] . "' $selected>" . $row['nome'] . "</option>";
                                    }
                                    $stmt->close();
                                } else {
                                    echo "<option value=''>Erro ao carregar tipo de despesa</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="textfield">
                            <label for="descricao">Descrição:</label>
                            <input type="text" name="descricao" id="descricao" value="<?php echo $descricao; ?>" required>
                        </div>
                        <div class="textfield">
                            <label for="valor">Valor:</label>
                            <input type="text" name="valor" id="valor" value="<?php echo $valor; ?>" required>
                        </div>
                        <div class="textfield">
                            <label for="data_despesa">Data:</label>
                            <input type="date" name="data_despesa" id="data_despesa" required>
                        </div>
                        <button class="btn-cad" type="submit">Atualizar</button>
                        <button class="btn-cad" onclick="history.back()">Voltar</button>
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