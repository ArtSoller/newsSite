<?php
include 'action/connect.php';

if( isset($_GET["section"]))
{
    try 
    {
    $section = (int)$_GET["section"];
    $sql = "SELECT * FROM news WHERE section = :section ORDER BY time DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":section", $section);
    $result = $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);   

    }
    
    catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/gerb.jpg" type="image/x-icon">
    <title>Лучшие новости</title>
</head>

<body>
    <?php
        include ("parts/header.php");
    ?>   

<main class="d-lg-flex">
        <?php
            include ("parts/aside.php");
        ?> 
        <div class="col-12 col-lg-1">
        </div>
        <div class="col-12 col-lg-8">            
            <div class="slider single-item" style="display: flex;
    align-items: center;
    justify-content: center; ">
                <?php foreach ($result as $row) : ?>
                    <div class="item" style="margin-top:10px;">
                        <div>
                            <span class="time">
                                <?= $ymd = DateTime::createFromFormat('Y-m-d H:i:s', $row["time"])->format('d M Y H:i:s')?>
                            </span>
                        </div>
                        <div class="card-body">
                            <a href="page.php?id=<?= $row["id"] ?>"><h2 id="h2" style="margin-left: 25px; margin-right: 25px;"> <?= $row["title"] ?> </h2></a>
                            <span style="margin-left: 25px; margin-right: 25px;"> <?= $row["description"] ?> </span>
                        </div>
                        <img src="<?= $row["img"] ?>" class="card-img-top rounded-0" alt="Обложка новости">
                        <div class="card-footer">
                            <a href="page.php?id=<?= $row["id"] ?>" class="btn btn-primary stretched-link w-100">Читать полностью</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

   <?php
        include 'parts/footer.php';
    ?>    
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src = "js/slick.min.js"></script>
    <script src = "js/script.js"></script>
</body>
</html>