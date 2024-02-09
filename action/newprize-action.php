<?php
include 'connect.php';

if (!$_SESSION['user']['is_admin'])
{
    header('Location: index.php');
    die();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["newprize_button"])) :
    
    $file = $_FILES['cover'];
    $fileName = $_FILES['cover']['name'];
    $fileTmpName = $_FILES['cover']['tmp_name'];
    $fileSize = $_FILES['cover']['size'];
    $fileError = $_FILES['cover']['error'];
    $fileType = $_FILES['cover']['type'];
    
    $fileExt = explode('.', $fileName);
    $fileActulalExt = strtolower(end($fileExt));
    
    $allowed = array('jpeg','jpg','png', 'gif', 'webp');
    
    if (!in_array($fileActulalExt, $allowed))
    {
        $_SESSION['message'] = 'Нельзя загружать файлы такого типа';
        header('Location: ../newprize.php');
        die();
    }
    
    if ($fileError !== 0)
    {
        $_SESSION['message'] = 'Ошибка во время загрузки: ' . $fileError;
        header('Location: ../newprize.php');
        die();
    }
    
    if($fileSize >= 44040192)
    {
        $_SESSION['message'] = 'Файл слишком большой';
        header('Location: ../newprize.php');
        die();
    }
    
    $fileNewName = uniqid('', true) . "." . $fileActulalExt;
    $fileDestination = '../img/' . $fileNewName;
    move_uploaded_file($fileTmpName, $fileDestination);
    $fileDestination = str_replace("../", "", $fileDestination);

    $sql = "INSERT INTO prizes (promo_id, prize_name, cover, prize_price) VALUES (:promo_id, :prize_name, :cover, :prize_price)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":promo_id", $_POST["promo_id"]);
    $stmt->bindValue(":prize_name", $_POST["prize_name"]);
    $stmt->bindValue(":cover", $fileDestination);
    $stmt->bindValue("prize_price", $_POST["prize_price"]);
    $stmt->execute();
    
    $_SESSION['message'] = 'Приз успешно добавлен';
    header("Location: ../settings.php?t=prizes");
    die();
endif;
?>