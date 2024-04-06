<?php
include('protect.php');
include('config.php');

//Obtem o nome do usuario da sessão
$usuario = $_SESSION['nome'];

// Inicialização das variáveis
$modelo = '';
$marca = '';
$ano = '';

// Verifica se o parâmetro ID foi passado na URL
if (!isset($_GET['id'])) {
    header("Location: veiculos.php"); // Redireciona de volta para a página de veículos se não houver ID
    exit();
}

// Obtém o ID do veículo da URL
$id = $_GET['id'];

// Consulta SQL para selecionar o veículo com o ID fornecido
$sql = "SELECT id, modelo, marca, ano FROM veiculos WHERE id = ?";

// Prepara e executa a consulta SQL
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o veículo foi encontrado
if ($result->num_rows === 0) {
    echo "Veículo não encontrado.";
    exit();
}

// Obtém os dados do veículo
$row = $result->fetch_assoc();
$modelo = $row['modelo'];
$marca = $row['marca'];
$ano = $row['ano'];

// Fecha a declaração
$stmt->close();
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
                <p class="font-weight-bold">EDITAR VEÍCULO</p>
            </div>

            <div div="editar-veiculo">
                <form action="atualizar_veiculo.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="card-cad-veiculos">
                        <div class="textfield">
                            <label for="idmodelo">Modelo</label>
                            <input type="text" name="modelo" id="idmodelo" required value="<?php echo htmlspecialchars($modelo); ?>">
                        </div>
                        <div class="textfield">
                            <label for="idmarca">Marca</label>
                            <input type="text" name="marca" id="idmarca" required value="<?php echo htmlspecialchars($marca); ?>">
                        </div>
                        <div class="textfield">
                            <label for="idano">Ano</label>
                            <input type="text" name="ano" id="idano" required value="<?php echo htmlspecialchars($ano); ?>">
                        </div>
                        <button class="btn-cad" type="submit">Atualizar</button>
                        <button class="btn-cad" onclick="history.back">Voltar</button>
                    </div>
                </form>
            </div>
        </main>
        <!--End Main -->
    </div>
    <!-- End grid-conteiner -->
    <!-- Chamando JS-->
    <script src="js/scripts.js"></script>
</body>
</html>