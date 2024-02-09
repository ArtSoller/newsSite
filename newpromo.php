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
            <p class="fw-bold fs-3">Добавление акции</p>
        </div>

        <form action="action/newpromo-action.php" method="post" class="my-4" enctype="multipart/form-data">

            <?php
            if (!empty($_SESSION['message']))
                echo '<p class="bg-warning text-center">'.$_SESSION['message'].'</p>';
            unset($_SESSION['message']);
            ?>

            <lable class="form-lable">Название акции</lable>
            <input type="text" class="form-control" name="promo_name" required>

            <lable class="form-lable">Описание акции</lable>
            <textarea type="text" class="form-control" name="promo_description" rows="10" required></textarea>

            <lable class="form-lable">Дата окончания акции</lable>
            <input type="datetime-local" class="form-control" name="promo_datetime" required>

            <input class="btn btn-success my-3" type="submit" value="Добавить акцию" name="newpromo_button">

        </form>
    </div>

    <?php
    ?>
</html>