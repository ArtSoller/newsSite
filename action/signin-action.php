<?php
include 'connect.php';

if (isset($_SESSION['user']))
{
    header('Location: index.php');
    die();
}

$_SESSION['message'] = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["signin_btn"])) :
    if (empty($_POST["login"]))
    {
        $_SESSION['message'] = 'Необходимо указать логин';
        header('Location: ../signin.php');
        die();
    }

    if (empty($_POST["password"]))
    {
        $_SESSION['message'] = 'Необходимо указать пароль';
        header('Location: ../signin.php');
        die();
    }               

    $sql = "INSERT INTO users (login, password, balance, is_admin) VALUES (:login, :password, :balance, :is_admin)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(":login", $_POST["login"]);
    $stmt->bindValue(":password", ($_POST["password"]));
    $stmt->bindValue(":balance", 0);
    $stmt->bindValue(":is_admin", 0);

    $stmt->execute();
    $_SESSION['message'] = 'Регистрация успешно завершена, можете войти';
    header("Location: ../avtorization.php");
    die();
endif;
?>