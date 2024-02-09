<?php
include 'connect.php';

if (!$_SESSION['user']['is_admin'])
{
    header('Location: index.php');
    die();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["newpromo_button"])) :
    
    $sql = "INSERT INTO promos1 (promo_name, promo_description, promo_datetime) VALUES (:promo_name, :promo_description, :promo_datetime)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":promo_name", $_POST["promo_name"]);
    $stmt->bindValue(":promo_description", $_POST["promo_description"]);
    $stmt->bindValue("promo_datetime", $_POST["promo_datetime"]);
    $stmt->execute();
    
    $_SESSION['message'] = 'Акция успешно добавлена';
    header("Location: ../settings.php?t=promos");
    die();
endif;
?>