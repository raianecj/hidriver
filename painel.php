<?php 
include ('protect.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hi Driver</title>

    <!-- Fonte Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

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
                <span class="material-icons-outlined">search</span>
            </div>
            <div class="header-right">
                <span class="material-icons-outlined">notifications</span>
                <span class="material-icons-outlined">email</span>
                <span class="material-icons-outlined">account_circle</span>
                <a href="logout.php" ><span class="material-icons-outlined">logout</span> </a>
                
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
                    <span class="material-icons-outlined">dashboard</span> Painel Inicial
                </li>
                <li class="sidebar-list-item">
                    <span class="material-icons-outlined">drive_eta</span> Veículos
                </li>
                <li class="sidebar-list-item">
                    <span class="material-icons-outlined">fact_check</span> Despesas
                </li>
                <li class="sidebar-list-item">
                    <span class="material-icons-outlined">calendar_month</span> Agenda
                </li>
                <li class="sidebar-list-item">
                    <span class="material-icons-outlined">poll</span> Relatórios
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
                        <p class="text-primary"> PRODUTOS </p>
                        <span class="material-icons-outlined text-blue">inventory_2</span>
                    </div>
                    <span class="text-primary font-weight-bold">249</span>
                </div>
                <div class="card">
                    <div class="card-inner">
                        <p class="text-primary"> ORDEM DE COMPRAS </p>
                        <span class="material-icons-outlined text-orange">add_shopping_cart</span>
                    </div>
                    <span class="text-primary font-weight-bold">83</span>
                </div>
                <div class="card">
                    <div class="card-inner">
                        <p class="text-primary"> ORDENS DE VENDA </p>
                        <span class="material-icons-outlined text-green">shopping_cart</span>
                    </div>
                    <span class="text-primary font-weight-bold">79</span>
                </div>
                <div class="card">
                    <div class="card-inner">
                        <p class="text-primary"> ALERTAS DE PRODUTOS </p>
                        <span class="material-icons-outlined text-red">notification_important</span>
                    </div>
                    <span class="text-primary font-weight-bold">56</span>
                </div>
            </div>
            <!-- End Cards -->
            <!-- Relatórios -->
            <div class="charts">
                <div class="charts-card">
                    <p class="chart-title">Top 5 Produtos</p>
                    <div id="bar-chart"></div>
                </div>
                <div class="charts-card">
                    <p class="chart-title">Pedidos de Compras e Vendas</p>
                    <div id="area-chart"></div>
                </div>
            </div>
            <!-- End Relatórios -->

        </main>
        <!--End Main -->

    </div> 
    <!-- End grid-conteiner -->

    <!-- Scripts -->
    <!-- ApexCharts: Biblioteca de Graficos e Relatórios -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.48.0/apexcharts.min.js"></script>

    <!-- Chamando JS-->
    <script src="js/scripts.js"></script>
</body>

</html>