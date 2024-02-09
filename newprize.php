<?php 
include 'action/connect.php';

if (!$_SESSION['user']['is_admin'])
{
    header('Location: index.php');
    die();
}

        include 'parts/header.php';

    ?>

    <div class="container">

        <div class="container text-center mt-3">
            <p class="fw-bold fs-3">Добавление приза</p>
        </div>

        <form action="action/newprize-action.php" method="post" class="my-4" enctype="multipart/form-data">

            <?php
            if (!empty($_SESSION['message']))
                echo '<p class="bg-warning text-center">'.$_SESSION['message'].'</p>';
            unset($_SESSION['message']);
            ?>

            <lable class="form-lable">Выберите акцию</lable>
            <select class="form-select" name="promo_id" required>
                <?php 
                $sql = "SELECT * FROM promos1 ORDER BY id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $promos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($promos as $promo) : ?>
                <option value=" <?= $promo['id'] ?> "><?= $promo['promo_name'] ?></option>
                <?php endforeach; ?>
            </select>

            <lable class="form-lable">Название приза</lable>
            <input type="text" class="form-control" name="prize_name" required>

            <lable class="form-lable">Обложка</lable>
            <input type="file" class="form-control" name="cover" required>

            <lable class="form-lable">Цена в баллах</lable>
            <input type="number" class="form-control" name="prize_price" required>

            <input class="btn btn-success my-3" type="submit" value="Добавить приз" name="newprize_button">

        </form>
    </div>

    <?php
    ?>