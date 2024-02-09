<?php
    include 'action/connect.php';
    if (isset($_SESSION['user']))
{
    header('Location: index.php');
    die();
}

    $sql = "SELECT * FROM users WHERE login = :login AND password = :password";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(":login", $_POST["login"]);
        $stmt->bindValue(":password", $_POST["password"]);

        $user=$stmt->execute();

    if($stmt->rowCount() > 0)
    {
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $_SESSION['user'] = array(
            'id' => $user[0]['id'],
            'is_admin' => $user[0]['is_admin'],
            'login' => $user[0]['login'],
        );
        header('Location: settings.php');
    }
    else
    {
        $_SESSION['message'] = "Неверный логин или пароль";
        header('Location: avtorization.php');
    }
?>