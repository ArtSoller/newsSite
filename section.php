<?php
include 'action/connect.php';

if( isset($_GET["section"]))
{
    try 
    {
    // $section = (int)$_GET["section"];
    // $sql = "SELECT * FROM news WHERE section = :section ORDER BY time DESC";
    // $stmt = $pdo->prepare($sql);
    // $stmt->bindValue(":section", $section);
    // $result = $stmt->execute();
    // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $section = (int)$_GET["section"];
    $sql = "SELECT * FROM news WHERE section = :section";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":section", $section);
    $result = $stmt->execute();
    $CountRows = $stmt->rowCount();

    $rowsPerPage = 2;
    $CountPages = ceil($CountRows / $rowsPerPage);
    
    if (isset($_GET['pg']))
    {
        $pg = $_GET['pg'];
    } 
    else 
    {
        $pg = 1;
    }
    
    $pg = (int)$pg;
    
    if ($pg === 0 || $pg < 1)
    {
        $pg = 1;
    }
    
    if ($pg > $CountPages)
    {
        $pg = $CountPages;
    }
    
    $startRow = ($pg - 1) *$rowsPerPage;
    
    $sqll = "SELECT * FROM news  WHERE section = :section LIMIT $startRow, $rowsPerPage" ;
    $stmtt = $pdo->prepare($sqll);
    $stmtt->bindValue(":section", $section);
    $resultf = $stmtt->execute();
    $resultf = $stmtt->fetchAll(PDO::FETCH_ASSOC);    

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/gerb.jpg" type="image/x-icon">
    <title>Лучшие новости</title>
</head>

<body>
    <?php
        include 'parts/header.php';
    ?>   

    <main class="d-lg-flex">
        <?php
            include 'parts/aside.php';
        ?> 
        <div class="col-12 col-lg-1">
        </div>

        <div class="col-12 col-lg-8">
            <?php foreach ($resultf as $row) : ?>
                <div class="item" style="margin-top:10px;">
                    <div class="card-header d-flex justify-content-between">
                        <span class="time">
                            <img width="20" height="20" style="margin-left: 25px;" src="img/time.jpg">
                            <?= $ymd = DateTime::createFromFormat('Y-m-d H:i:s', $row["time"])->format('d M Y H:i:s')?>
                        </span>
                    </div>
                    <div class="card-body">
                        <a href="page.php?id=<?= $row["id"] ?>"><h2 id="h2" style="margin-left: 25px; margin-right: 25px;"> <?= $row["title"] ?> </h2></a>
                        <span style="margin-left: 25px; margin-right: 25px;"> <?= $row["description"] ?> </span>
                    </div>
                    <img src="<?= $row["img"] ?>" class="card-img-top rounded-0" alt="Обложка новости">
                </div>
            <?php endforeach; ?>

            <div class="nav justify-content-center">
                    <a href="?pg=1" class = "btn btn-dark border mx-2">К началу</a>
                    <a href="<?php echo "?pg=".($pg - 1)?>" class = "<?php if ($pg == 1) {echo 'disabled';}?> btn btn-dark border mx-2">Предыдущая</a>
                    <a href="<?php echo "?pg=".($pg + 1)?>" class = "<?php if ($pg == $CountPages) {echo 'disabled';}?> btn btn-dark border mx-2">Следующая</a>
                    <a href="?pg=<?= $CountPages ?>" class = "btn btn-dark border mx-2">К концу</a>
                </div>
        </div>
    </main>

   <a href="#" title="Вернуться к началу страницы" class="topNubex icon" data-char="^"></a>

   <?php
        include 'parts/footer.php';
    ?>    
</body>
</html>