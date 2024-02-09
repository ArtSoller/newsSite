<?php
include 'connect.php';
if (!$_SESSION['user']['is_admin'])
{
    header('Location: index.php');
    die();
}

if (isset($_POST["id"]) && 
    isset($_POST["title"]) && 
    isset($_POST["time"]) && 
    isset($_POST["description"]) && 
    isset($_POST["img"]) && 
    isset($_POST["body"]) && 
    isset($_POST["section"])) :
    try {   
        $sql = "UPDATE news SET title = :title, time = :time, description = :description, img = :img, body = :body, section = :section  WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(":id", $_POST["id"]);
        $stmt->bindValue(":title", $_POST["title"]);
        $stmt->bindValue(":time", $_POST["time"]);
        $stmt->bindValue(":description", $_POST["description"]);
        $stmt->bindValue(":img", $_POST["img"]);
        $stmt->bindValue(":body", $_POST["body"]);
        $stmt->bindValue(":section", $_POST["section"]);

        $stmt->execute();

        header("Location: ../settings.php");
        die();
    }
    catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
endif;
?>