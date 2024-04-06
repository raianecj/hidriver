<?php
include('protect.php');
include('config.php');

//Obtem o nome do usuario da sessão
$usuario = $_SESSION['nome'];

// Consulta SQL para contar o número de veículos cadastrados
$sql = "SELECT COUNT(*) AS total_veiculos FROM veiculos";

// Executa a consulta SQL
$result = $mysqli->query($sql);

// Verifica se a consulta foi bem-sucedida
if ($result) {
    // Obtém o número total de veículos cadastrados
    $row = $result->fetch_assoc();
    $total_veiculos = $row['total_veiculos'];
} else {
    // Em caso de erro na consulta, define o total de veículos como 0
    $total_veiculos = 0;
}

// Fecha a conexão com o banco de dados
$mysqli->close();
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
                <span class="user-name font-weight-bold"><?php echo "Hi $usuario"; ?></span>
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
                    <a href="#">
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
                <p class="font-weight-bold">PAINEL INICIAL</p>
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
        </main>
        <!--End Main -->

    </div>
    <!-- End grid-conteiner -->
    <!-- Chamando JS-->
    <script src="js/scripts.js"></script>
</body>

</html>