<?php
include('protect.php');
include('config.php');

//Obtem o nome do usuario da sessão
$usuario = $_SESSION['nome'];

$veiculo_sucess = ''; // Variável para armazenar mensagem sucesso de criação de usuário
$veiculo_error = ''; // Variável para armazenar mensagem erro de criação de usuário

$modelo = ''; // Define a variável $modelo
$marca = ''; // Define a variável $marca
$ano = ''; // Define a variável $ano

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se o campo "ano" contém apenas números
    if (!is_numeric($_POST["ano"])) {
        $veiculo_error = "O campo 'Ano' deve conter apenas números";
    } else {
        // Se o ano for numérico, continue com o processamento do formulário
        $modelo = $_POST["modelo"];
        $marca = $_POST["marca"];
        $ano = $_POST["ano"];

        // Inserindo os dados no BD
        $sql = "INSERT INTO veiculos (modelo, marca, ano) VALUES (?, ?, ?)";

        // Prepara a consulta sql de forma segura
        $stmt = $mysqli->prepare($sql);

        //Garante que os dados sejam tratados de forma correta e segura
        $stmt->bind_param("sss", $modelo, $marca, $ano);

        //Executa a consulta sql e retorna msg de sucesso ou erro
        if ($stmt->execute()) {
            $veiculo_sucess = "Veiculo cadastrado com sucesso!";
            // Limpar os campos do formulário
            $modelo = '';
            $marca = '';
            $ano = '';

            // Redirecionar para uma página de sucesso
            header("Location: cad_veiculo.php?success=true");
        } else {
            $veiculo_error = "Erro: " . $sql . "<br>" . $mysqli->error;
        }

        // Fecha declaração
        $stmt->close();
    }
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
            <div div="cad-veiculos">
                <form action="" method="post">
                    <div class="card-cad-veiculos">
                        <div class="textfield">
                            <label for="">Modelo</label>
                            <input type="text" name="modelo" id="idmodelo" required value="<?php echo htmlspecialchars($modelo); ?>">
                        </div>
                        <div class="textfield">
                            <label for="">Marca</label>
                            <input type="text" name="marca" id="idmarca" required value="<?php echo htmlspecialchars($marca); ?>">
                        </div>
                        <div class="textfield">
                            <label for="">Ano</label>
                            <input type="text" name="ano" id="idano" required value="<?php echo htmlspecialchars($ano); ?>">
                        </div>
                        <button class="btn-cad" type="submit">Cadastrar</button>
                        <br>
                        <span class="error"><?php echo $veiculo_error; ?></span> <!-- Exibe a mensagem de erro de veiculo -->
                        <span class="sucess"><?php echo $veiculo_sucess; ?></span> <!-- Exibe a mensagem de veiculo cadastrado -->
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