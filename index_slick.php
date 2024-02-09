<?php 
include 'action/connect.php';

$sql = "SELECT * FROM news ORDER BY time DESC";
 $result = $pdo->query($sql);
 ?>


<!DOCTYPE html>
<?php
    include 'parts/header.php';
?>  

<body class="page">
    <main class="d-lg-flex">
        <?php
            include ("parts/aside.php");
        ?> 
        <div class="col-12 col-lg-9">
            
                <div class="slider single-item">
                <?php foreach ($result as $row) : ?>
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
                    <img src="<?= $row["img"] ?>" class="card-img-top rounded-0" width="400" height="630" alt="Обложка новости">
                </div>
            <?php endforeach; ?>
                </div>
                <div class="nav justify-content-center">
                    <a href="?p=1" class = "btn btn-dark border mx-2">К началу</a>
                    <a href="<?php echo "?p=".($p - 1)?>" class = " <?php if ($p == 1) {echo 'disabled';}?> btn btn-dark border mx-2">Предыдущая</a>
                    <a href="<?php echo "?p=".($p + 1)?>" class = "<?php if ($p == $CountPages) {echo 'disabled';}?> btn btn-dark border mx-2">Следующая</a>
                    <a href="?p=<?= $CountPages ?>" class = "btn btn-dark border mx-2">К концу</a>
                </div>
        </div>
    </main>

   <a href="#" title="Вернуться к началу страницы" class="topNubex icon" data-char="^"></a>

   <?php
        include ("parts/footer.php")
    ?>    
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src = "js/slick.min.js"></script>
    <script src = "js/script.js"></script>

</body>
</html>