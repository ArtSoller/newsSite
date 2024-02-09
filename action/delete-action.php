<?php
include 'connect.php';
if (!$_SESSION['user']['is_admin'])
{
    header('Location: index.php');
    die();
}

if(isset($_POST["id"]))
{
    try {
        $sql = "DELETE FROM news WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id", $_POST["id"]);
        $stmt->execute();
        header("Location: ../settings.php");
        die();
    }
    catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>