<?php 
include 'action/connect.php';

// $sql = "SELECT * FROM news ORDER BY time DESC";
//  $result = $pdo->query($sql);
//  $CountRows = $result->rowCount();

$sql = "SELECT COUNT(id) FROM news";
// $result  = $pdo->query($sql);
// $data = $result->fetchAll(PDO::FETCH_ASSOC); 
// echo $data['c'];

$result = $pdo->prepare($sql); 
$result->execute(); 
$number_of_rows = $result->fetchColumn(); 


 $rowsonPage = 2;
 $CountPages = ceil($number_of_rows / $rowsonPage);
 
 if (isset($_GET['p']))
 {
     $p = $_GET['p'];
 } 
 else 
 {
     $p = 1;
 }
 
 $p = (int)$p;
 
 if ($p === 0 || $p < 1)
 {
     $p = 1;
 }
 
 if ($p > $number_of_rows)
 {
     $p = $number_of_rows;
 }
 
 $firstRow = ($p - 1) *$rowsonPage;
 
 $sql = "SELECT * FROM news  ORDER BY time DESC LIMIT $firstRow, $rowsonPage" ;
 $result = $pdo->query($sql);
 ?>


<!DOCTYPE html>
<?php
    include ("parts/header.php");
?>   

<body>

    <main class="d-lg-flex">
        <?php
            include ("parts/aside.php");
        ?> 
        <div class="col-12 col-lg-1">
</div>
        <div class="col-12 col-lg-8">
            <?php foreach ($result as $row) : ?>
                <div class="item" style="margin-top:10px;">
                    <div>
                    <?= $ymd = DateTime::createFromFormat('Y-m-d H:i:s', $row["time"])->format('d M Y H:i:s')?>
                    </div>
                    <div class="card-body div">
                        <a href="page.php?id=<?= $row["id"] ?>"><h2 id="h2" style="margin-left: 25px; margin-right: 25px;"> <?= $row["title"] ?> </h2></a>
                        <span> <?= $row["description"] ?> </span>
                    </div>
                    <img src="<?= $row["img"] ?>" class="card-img-top rounded-0" alt="Обложка новости">
                    <div class="card-footer">
                      <a href="page.php?id=<?= $row["id"] ?>" class="btn btn-primary stretched-link w-100">Читать полностью</a>
                     </div>
                </div>

            <?php endforeach; ?>

                <div class="nav justify-content-center">
                    <a href="?p=1" class = "btn btn-dark border mx-2">К началу</a>
                    <a href="<?php echo "?p=".($p - 1)?>" class = " <?php if ($p == 1) {echo 'disabled';}?> btn btn-dark border mx-2">Предыдущая</a>
                    <a href="<?php echo "?p=".($p + 1)?>" class = "<?php if ($p == $CountPages) {echo 'disabled';}?> btn btn-dark border mx-2">Следующая</a>
                    <a href="?p=<?= $number_of_rows ?>" class = "btn btn-dark border mx-2">К концу</a>
                </div>
        </div>
    </main>

   <a href="#" title="Вернуться к началу страницы" class="topNubex icon" data-char="^"></a>

   <?php
        include ("parts/footer.php")
    ?>    
</body>
</html>