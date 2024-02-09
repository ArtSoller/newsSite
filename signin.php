<?php
include 'action/connect.php';

if (isset($_SESSION['user']))
{
    header('Location: index.php');
    die();
}
?>

    <?php
        include ("parts/header.php");
    ?>

    <div class="container d-flex justify-content-center">
        <div class="col-7 col-sm-6 col-md-5 col-lg-4 col-xl-3">
            <form action="action/signin-action.php" method="post" class="my-4" enctype="multipart/form-data">


                <lable class="form-lable">Логин</lable>
                <input type="text" class="form-control" name="login">
                
                <label class="form-lable">Пароль</label>
                <input type="password" class="form-control" name="password">
                
                <input class="btn btn-success my-4 w-100" type="submit" value="Зарегистрироваться" name="signin_btn">
                
                <?php
                if (!empty($_SESSION['message']))
                    echo '<p class="bg-warning text-center">'.$_SESSION['message'].'</p>';
                unset($_SESSION['message']);
                ?>
            </form>
            
            <div  class="text-center">
                    <p>Уже есть аккаунт? <a href="avtorization.php">Войдите!</a></p>
                </div>
        </div> 
    </div>    