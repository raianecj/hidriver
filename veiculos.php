<?php
include('protect.php');

//Obtem o nome do usuario da sessão
$usuario = $_SESSION['nome'];
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
                <span class="user-name"><?php echo "Olá $usuario"; ?></span>
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
                    <a href="despesas.php">
                        <span class="material-icons-outlined">fact_check</span> Despesas
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="agenda.php">
                        <span class="material-icons-outlined">calendar_month</span> Agenda
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="relatorios.php">
                        <span class="material-icons-outlined">poll</span> Relatórios
                    </a>
                </li>

            </ul>
        </aside>
        <!-- End Sidebar -->

        <!-- Main: Conteudo principal da página -->

        <main class="main-conteiner">


            <div class="main-title">
                <p class="font-weight-bold">MEUS VEÍCULOS</p>
            </div>
            <!-- Read Veículos -->
            <table class="crud-table">
                <tr>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Ano</th>
                    <th>Ações</th>
                </tr>

                <?php
                include('config.php');
                $sql = "SELECT id, modelo, marca, ano FROM veiculos";

                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["modelo"] . "</td>";
                        echo "<td>" . $row["marca"] . "</td>";
                        echo "<td>" . $row["ano"] . "</td>";
                        echo "<td>";
                        echo "<a href='editar_veiculo.php?id=" . $row["id"] . "'><span class='material-icons-outlined text-primary' title='Editar'>cached</span></a> | ";
                        echo "<a href='excluir_veiculo.php?id=" . $row["id"] . "'><span class='material-icons-outlined text-primary' title='Excluir'>delete</span></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Nenhum veículo cadastrado";
                }
                $mysqli->close();
                ?>
            </table>
            <!-- End Read Veículos -->

            <!-- Cadastrar veículos-->

            <br><a href="cad_veiculo.php">
                <p class="font-weight-bold">
                    <span class="material-icons-outlined">add_box</span> Cadastrar Veiculo
                </p>
            </a>
        </main>

        <!--End Main -->

    </div>
    <!-- End grid-conteiner -->

    <!-- Scripts -->



    <!-- Chamando JS-->

</body>

</html>