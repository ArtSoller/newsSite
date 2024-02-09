<?php 
include 'action/connect.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) :
    try {
        $id = $_GET["id"];
        $sql = "SELECT * FROM news WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute(); 
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
    catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
?>

<!DOCTYPE html>
<?php
    include 'parts/header.php';
?>  

<body>
    <div class="container">
        <?php 
        foreach($result as $row):
            $title = $row["title"];
            $time = $row["time"];
            $description = $row["description"];
            $img = $row["img"];
            $body = $row["body"];
            $section = $row["section"];
        ?>

        <form action="action/up-action.php" method="post" class="my-4" enctype="multipart/form-data">
            <div class="form-group">
                
                <input type="hidden" class="form-control" name="id" value="<?= $id ?>">

                <lable class="form-lable">Заголовок</lable>
                <input type="text" class="form-control" name="title" value="<?= $title ?>">

                <lable class="form-lable">Время</lable>
                <input type="datetime-local" class="form-control" name="time" value="<?= $time ?>">

                <lable class="form-lable">Описание</lable>
                <input type="text" class="form-control" name="description" value="<?= $description ?>">

                <lable class="form-lable">Обложка</lable>
                <input type="text" class="form-control" name="img" value="<?= $img ?>">
                <small class="form-text text-muted">Если хотите сменить обложку, выберите файл</small>
                <input type="file" class="form-control" name="img1">

                <lable class="form-lable">Новость</lable>
                <textarea type="text" class="form-control" name="body" rows="20"><?= $body ?></textarea>

                <lable class="form-lable">Выбрать секцию</lable>
                <input type="text" class="form-control" name="section" value="<?= $section ?>">
                <small class="form-text text-muted">1 - Экономика, 2 - Политика, 3 - Наука, 4 - Культура, 5 - Спорт</small>
            </div>
            <input class="btn btn-success my-3" type="submit" value="Save" name="update">

        </form>
        <?php
        endforeach;
        endif;
        ?>        
    </div>
</body>
</html>