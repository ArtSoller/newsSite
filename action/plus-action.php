<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["plus-button"]))
{
    $code = $_POST["code"];

    $sql = "SELECT `value` FROM codes WHERE code = :code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':code', $code);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result)
    {
        $_SESSION['message'] = "Такого кода не существует";
        header('Location: ../promotions.php');
        die();
    }

    $value = $result["value"];

    // $sql = "SELECT `login` FROM codes WHERE code = :code";
    // $stmt = $pdo->prepare($sql);
    // $stmt->bindValue(':code', $code);
    // $stmt->execute();


    $sql = "UPDATE users SET balance = balance + :value WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':value', $value);
    $stmt->bindValue(':id', $_SESSION['user']['id']);
    $stmt->execute();

    $sql = "DELETE FROM codes WHERE code = :code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':code', $code);
    $stmt->execute();

    $sql = "INSERT INTO codes (code, value, login) VALUES (:code, :value, :login)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(":code", $_POST["code"]);
    $stmt->bindValue(":value", $_POST["value"]);
    $stmt->bindValue(":login", $_POST["login"]);


    
    $stmt->execute();

    $_SESSION['message'] = "Баланс увеличен на " . $value . "!";
    header('Location: ../promotions.php');
    die();
}
?>