<?php
include 'action/connect.php';

    if(isset($_SESSION["user"]))
    {
        header('Location: settings.php');
    }
?>


<!DOCTYPE html>
<?php
    include ("parts/header.php");
?>  

<body>
 

    <!-- Форма авторизации -->

    <div class="container d-flex justify-content-center">
        <div class="col-7 col-sm-6 col-md-5 col-lg-4 col-xl-3">
            <form action="avtorization-action.php" method="post" class="my-4">

                <lable class="form-lable">Логин</lable>
                <input type="text" class="form-control" name="login" placeholder="Введите свой логин">
                
                <label class="form-lable">Пароль</label>
                <input type="password" class="form-control" name="password" placeholder="Введите свой пароль">
                
                <input class="btn btn-success my-4 w-100" type="submit" value="Войти" name="signin_btn">
                
                <?php
                if (!empty($_SESSION['message']))
                    echo '<p class="bg-warning text-center">'.$_SESSION['message'].'</p>';
                unset($_SESSION['message']);
                ?>
            </form>
            
            <div class="text-center">
                <p>Еще нет аккаунта? <a href="signin.php">Зарегистрируйтесь!</a></p>
            </div>
        </div> 
    </div>        
</body>
</html>