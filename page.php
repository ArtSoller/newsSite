<?php
include 'action/connect.php';

if( $_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"]))
{
    try {
    $id = $_GET["id"];
    $sql = "SELECT * FROM news WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $id);
    $result = $stmt->execute();
    $resultf = $stmt->fetchAll(PDO::FETCH_ASSOC);    

    }
    
    catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<?php
    include 'parts/header.php';
?>  

<body class="page">
 

    <main class="d-lg-flex">
        <?php
            include 'parts/aside.php';
        ?>
        <div class="col-12 col-lg-7">
            <?php
                if ($result > 0) :
            ?>
            <div class="item" style="margin-top:10px;">
                <div class="card-header d-flex justify-content-between time">
                    <span class="time">
                        <img width="20" height="20" style="margin-left: 25px;" src="img/time.jpg">
                        <?= $ymd = DateTime::createFromFormat('Y-m-d H:i:s', $resultf[0]["time"])->format('d M Y H:i:s')?>
                    </span>
                </div>
                <div class="card-body">
                    <h2 id="h2" style="margin-left: 25px; margin-right: 25px;"> <?= $resultf[0]["title"] ?> </h2>
                    <span style="margin-left: 25px;"> <?= $resultf[0]["description"] ?> </span>
                </div>
                <img src="<?= $resultf[0]["img"] ?>" class="card-img-top rounded-0" alt="Обложка новости">
                <div class="card-body">
                <span style="margin-left: 25px;"><?= nl2br($resultf[0]["body"]) ?></span>
                </div>
            </div>
            <?php 
                endif;
            ?>
        </div>
    </main>

   <a href="#" title="Вернуться к началу страницы" class="topNubex icon" data-char="^"</a>

   <?php
        include 'parts/footer.php';
    ?>    
</body>
</html>