<?php 
include 'action/connect.php';

if (!$_SESSION['user']['is_admin'])
{
    header('Location: index.php');
    die();
}
?>

<!DOCTYPE html>
<?php
    include 'parts/header.php';
?>  

<body>
    <div class="container">
        <form action="action/create-action.php" method="post" class="my-4" enctype="multipart/form-data">

            <lable class="form-lable">Заголовок</lable>
            <input type="text" class="form-control" name="title" placeholder="Введите заголовок новости">

            <lable class="form-lable">Время</lable>
            <input type="date" class="form-control" name="time" value="<?php echo date("Y-m-d") ?>" readonly>

            <lable class="form-lable">Описание</lable>
            <input type="text" class="form-control" name="description" placeholder="Введите описание новости">

            <lable class="form-lable">Обложка</lable>
            <input type="file" class="form-control" name="img">

            <lable class="form-lable">Новость</lable>
            <textarea type="text" class="form-control" name="body" rows="20" placeholder="Введите новость"></textarea>

            <lable class="form-lable">Выбрать секцию</lable>
            <select class="form-control" name="section">
                <option>1 - Экономика</option>
                <option>2 - Политика</option>
                <option>3 - Наука</option>
                <option>4 - Культура</option>
                <option>5 - Спорт</option>
            </select>
            
            <input class="btn btn-success my-3" type="submit" value="Calculate" name="add">
        </form>
    </div>
</body>
</html>