<?php
include 'connect.php';
if (!$_SESSION['user']['is_admin'])
{
    header('Location: index.php');
    die();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add"]) && isset($_POST["id"]) && 
isset($_POST["title"]) && 
isset($_POST["time"]) && isset($_POST["description"]) && 
isset($_POST["img"]) && 
isset($_POST["body"]) && 
isset($_POST["section"])) {
    try {
        $file = $_FILES['img'];
        $fileName = $_FILES['img']['name'];
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileSize = $_FILES['img']['size'];
        $fileError = $_FILES['img']['error'];
        $fileType = $_FILES['img']['type'];
    
        $fileExt = explode('.', $fileName);
        $fileActulalExt = strtolower(end($fileExt));
    
        $allowed = array('jpeg','jpg','png','gif');
    
        if (in_array($fileActulalExt, $allowed))
        {
            if ($fileError === 0)
            {
                if($fileSize < 44040192)
                {
                    $fileNewName = uniqid('', true) . "." . $fileActulalExt;
                    $fileDestination = '../img/' . $fileNewName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $fileDestination = str_replace("../", "", $fileDestination);
                }
                else
                {
                    echo "File is too big";
                    die();
                }
            }
            else
            {
                echo "Error during uploading:" . $fileError;
                die();
            }
    
        }
        else
        {
            echo "You cannot upload files of this type.";
            die();
        }
        $sql = "INSERT INTO news (title, time, description, img, body, section) VALUES (:title, :time, :description, :img, :body, :section)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(":title", $_POST["title"]);
        $stmt->bindValue(":time", $_POST["time"]);
        $stmt->bindValue(":description", $_POST["description"]);
        $stmt->bindValue(":img", $fileDestination);
        $stmt->bindValue(":body", $_POST["body"]);
        $stmt->bindValue(":section", $_POST["section"]);
        
        $stmt->execute();
        header("Location: ../settings.php");
        die();
    }
    catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
else{
    echo "Some fields are not filled";
}
?>