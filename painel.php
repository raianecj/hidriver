<?php
include('protect.php');
include('config.php');

//Obtem o nome do usuario da sessão
$usuario = $_SESSION['nome'];

// Consulta SQL para contar o número de veículos cadastrados
$sql = "SELECT COUNT(*) AS total_veiculos FROM veiculos WHERE id_usuario = ?";

// Prepara a consulta SQL de forma segura
$stmt = $mysqli->prepare($sql);

// Verifica se a preparação da consulta foi bem-sucedida
if ($stmt) {
    // Vincula o parâmetro da consulta
    $stmt->bind_param("i", $_SESSION['id']);

    // Executa a consulta
    $stmt->execute();

    // Vincula o resultado da consulta
    $stmt->bind_result($total_veiculos);

    // Obtém o resultado da consulta
    $stmt->fetch();

    // Fecha a declaração
    $stmt->close();
} else {
    // Em caso de erro na preparação da consulta, define o total de veículos como 0
    $total_veiculos = 0;
}
// Consulta SQL para calcular o valor total das despesas
$sql_total_despesas = "SELECT SUM(valor) AS total_despesas FROM despesas WHERE id_veiculo IN (SELECT id FROM veiculos WHERE id_usuario = ?)";

// Prepara a consulta SQL de forma segura
$stmt_total_despesas = $mysqli->prepare($sql_total_despesas);

// Verifica se a preparação da consulta foi bem-sucedida
if ($stmt_total_despesas) {
    // Vincula o parâmetro da consulta
    $stmt_total_despesas->bind_param("i", $_SESSION['id']);

    // Executa a consulta
    $stmt_total_despesas->execute();

    // Vincula o resultado da consulta
    $stmt_total_despesas->bind_result($total_despesas);

    // Obtém o resultado da consulta
    $stmt_total_despesas->fetch();

    // Fecha a declaração
    $stmt_total_despesas->close();
} else {
    // Em caso de erro na preparação da consulta, define o total de despesas como 0
    $total_despesas = 0;
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

        <!-- Main: Conteudo principal da página -->
        <main class="main-conteiner">
            <div class="main-title">
                <h2>PAINEL INICIAL</h2>
            </div>
            <!-- Cards -->
            <div class="main-cards">
                <div class="card">
                    <div class="card-inner">
                        <a href="veiculos.php">
                            <p class="text-primary"> VEÍCULOS </p>
                        </a>
                        <span class="material-icons-outlined text-blue">drive_eta</span>
                    </div>
                    <span class="text-primary font-weight-bold"><?php echo $total_veiculos; ?></span>
                </div>
                <div class="card">
                    <div class="card-inner">
                        <a href="cad_despesas.php">
                            <p class="text-primary"> DESPESAS </p>
                        </a>
                        <span class="material-icons-outlined text-red">paid</span>
                    </div>
                    <span class="text-primary font-weight-bold">R$ <?php echo $total_despesas; ?></span>
                </div>
            </div>
            <!-- End Cards -->
            <!-- Histórico das Despesas -->
            <div class="timeline">
                <div class="main-title">
                    <h3>Histórico</h3>
                </div>
                <ul>
                    <?php
                    // Consultar despesas e veículos do usuário, incluindo o nome do tipo de despesa
                    $sql = "SELECT d.id, td.nome AS tipo_despesa, d.valor, v.modelo, d.data_despesa
                    FROM despesas AS d
                    INNER JOIN veiculos AS v ON d.id_veiculo = v.id
                    INNER JOIN tipo_despesa AS td ON d.tipo_despesa = td.id
                    WHERE v.id_usuario = ?
                    ORDER BY d.data_despesa DESC"; // Ordenar pela data da despesa de forma descendente
                    $stmt = $mysqli->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("i", $_SESSION['id']);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Exibir os resultados na linha do tempo
                        while ($row = $result->fetch_assoc()) {
                            echo "<li>";
                            echo "<strong>Veículo:</strong> " . $row['modelo'] . "<br>";
                            echo "<strong>Tipo:</strong> " . $row['tipo_despesa'] . "<br>";
                            echo "<strong>Valor:</strong> R$ " . $row['valor'] . "<br>";

                            // Formatar a data para o estilo brasileiro (dd/mm/aaaa)
                            $data_formatada = date("d/m/Y", strtotime($row['data_despesa']));
                            echo "<strong>Data:</strong> " . $data_formatada;
                            // Adicionar botões de ação para editar e excluir
                            echo "<div class='action-buttons-timeline'>";
                            echo "<a href='editar_despesa.php?id=" . $row["id"] . "'><span class='material-icons-outlined text-primary' title='Editar'>cached</span></a> | ";
                            echo "<a href='excluir_despesa.php?id=" . $row["id"] . "' onclick='return confirm(\"Tem certeza de que deseja excluir esta despesa?\")'><span class='material-icons-outlined text-primary' title='Excluir'>delete</span></a>";
                            echo "</div>"; // Fechar o contêiner de botões de ação
                            echo "</li>";
                        }

                        $stmt->close();
                    }
                    ?>
                </ul>
            </div>

        </main>
        <!--End Main -->

    </div>
    <!-- End grid-conteiner -->
    <!-- Chamando JS-->
    <script src="js/scripts.js"></script>
</body>

</html>