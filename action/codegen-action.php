<?php

function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}

include 'connect.php';
if (!$_SESSION['user']['is_admin'])
{
    header('Location: index.php');
    die();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["codegen_button"]))
{
    $permitted_chars = $_POST['permitted_chars'];
    $length = $_POST['length'];
    $count = (int) $_POST['count'];
    $min_value = $_POST['min_value'];
    $max_value = $_POST['max_value'];

    for ($i = 1; $i <= $count; $i++) 
    {
        $code = generate_string($permitted_chars, $length);
        $value = mt_rand($min_value, $max_value);
    
        $sql = "INSERT INTO codes (code, value) VALUES (:code, :value)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":code", $code);
        $stmt->bindValue(":value", $value);
    
        $stmt->execute();
    }

    
    $_SESSION['message'] = 'Коды успешно добавлены';
    header("Location: ../settings.php?t=codes");
    die();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["codeadd_button"]))
{

    $code = $_POST['new_code'];
    $value = $_POST['new_value'];

    $sql = "INSERT INTO codes (code, value) VALUES (:code, :value)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":code", $code);
    $stmt->bindValue(":value", $value);

    $stmt->execute();

    
    $_SESSION['message'] = 'Код успешно добавлен';
    header("Location: ../settings.php?t=codes");
    die();
}

?>