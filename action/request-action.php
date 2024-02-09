<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["request_button"]))
{
    date_default_timezone_set('Asia/Novosibirsk');
    
    $current_datetime = new DateTime(date('Y-m-d H:i:s'));
    $offer_end = new DateTime($_POST['promo_datetime']);

    if ($offer_end < $current_datetime){
        $_SESSION['message'] = "Вы опоздали!";
        header('Location: ../index.php');
        die();
    }

    $sql = "INSERT INTO requests (user_id, promo_id, prize_id) VALUES (:user_id, :promo_id, :prize_id)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(":user_id", $_SESSION['user']['id']);
    $stmt->bindValue(":promo_id", $_POST["promo_id"]);
    $stmt->bindValue(":prize_id", $_POST["prize_id"]);
    $stmt->execute();

    $sql = "UPDATE users SET balance = balance - :value WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':value', $_POST["prize_price"]);
    $stmt->bindValue(':id', $_SESSION['user']['id']);
    $stmt->execute();

    $_SESSION['message'] = "Приз заказан!";
    header('Location: ../promotions.php');
    die();
}
?>