<!-- Pagina para encerrar a sessão -->
<?php
if (!isset($_SESSION)) {
    session_start();
}
session_destroy();

header("Location: index.php");
?>