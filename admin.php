<?php
include 'action/connect.php';

include ("parts/header.php");

if (!$_SESSION['user']['is_admin'])
{
    header('Location: index-.php');
    die();
}

if (isset($_GET['t']))
{
    switch ($_GET['t'])
    {
        case "news":
        case "promos":
        case "prizes":
        case "requests":
        case "users":
        case "codes":
            $t = $_GET['t'];
            break;
        default:
            $t = "news";
            break;
    }
} 
else 
{
    $t = "news";
} ?>

<div class="container">

    <?php 
    if (!empty($_SESSION['message']))
        echo '<p class="bg-success text-white text-center mt-3">'.$_SESSION['message'].'</p>';
    unset($_SESSION['message']);
    ?>

    <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-5 g-3 mt-3">
        <div class="col ">
            <a href="?t=news" class="btn btn-primary w-100 my-1">Новости</a>
            <a href="create.php" class="btn bg-primary-subtle border border-dark w-100 my-1">Добавить новость</a>
        </div>
        <div class="col">
            <a href="?t=promos" class="btn btn-danger w-100 my-1">Акции</a>
            <a href="newpromo.php", class="btn bg-danger-subtle border border-dark w-100 my-1">Добавить акцию</a>
        </div>
        <div class="col">
            <a href="?t=prizes" class="btn btn-warning w-100 my-1">Призы</a>
            <a href="newprize.php", class="btn bg-warning-subtle border border-dark w-100 my-1">Добавить приз</a>
        </div>
        <div class="col">
            <a href="?t=requests" class="btn btn-success w-100 my-1">Выигрыши</a>
            <a href="?t=codes", class="btn bg-success-subtle border border-dark w-100 my-1">Коды</a>
        </div>
        <div class="col">
            <a href="?t=users", class="btn btn-info w-100 my-1">Пользователи</a>
        </div>
    </div>



<?php
if($t == "news") :   
    $sql = "SELECT * FROM lab3 ORDER BY id";
    $result = $pdo->query($sql);
    ?>
        <div class="row mt-4">
            <div class="col table-responsive">
            <table class="table table-striped table-hover table-primary">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Заголовок</th>
                        <th>Дата публикации</th>
                        <th>Описание</th>
                        <th>Обложка</th>
                        <th>Текст</th>
                        <th>Секция</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= $row["title"] ?></td>
                        <td><?= $row["time"] ?></td>
                        <td><?= $row["description"] ?></td>
                        <td><?= $row["img"] ?></td>
                        <td><?= $row["body"] ?></td>
                        <td><?= $row["section"] ?></td>
                        <td>
                            <a href="update.php?id=<?= $row["id"] ?>" class="btn btn-primary">Редактировать</a>
                            <form action="action/delete-action.php" method="post">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <input type="submit" value="Удалить" class="btn btn-danger">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
<?php endif; ?>

<?php if($t == "promos") : 
    $sql = "SELECT * FROM promos ORDER BY id";
    $result = $pdo->query($sql);
    ?>
        <div class="row mt-4">
            <div class="col table-responsive">
            <table class="table table-striped table-hover table-danger">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Название акции</th>
                        <th>Описание акции</th>
                        <th>Дата завершения акции</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= $row["promo_name"] ?></td>
                        <td><?= $row["promo_description"] ?></td>
                        <td><?= $row["promo_datetime"] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
<?php endif; ?>

<?php if($t == "prizes") :
    $sql = "SELECT *, promos.promo_name FROM prizes 
    LEFT JOIN promos ON (prizes.promo_id = promos.id) ORDER BY promos.promo_name";
    $result = $pdo->query($sql);
    ?>
        <div class="row mt-4">
            <div class="col table-responsive">
            <table class="table table-striped table-hover table-warning">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Название акции</th>
                        <th>Название приза</th>
                        <th>Фото приза</th>
                        <th>Цена приза</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= $row["promo_name"] ?></td>
                        <td><?= $row["prize_name"] ?></td>
                        <td><?= $row["cover"] ?></td>
                        <td><?= $row["prize_price"] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>

<?php endif; ?>

<?php if($t == "requests") :
    $sql = "SELECT requests.id, promos.promo_name, prizes.prize_name, users.lgn FROM requests 
    LEFT JOIN promos ON (requests.promo_id = promos.id)
    LEFT JOIN prizes ON (requests.prize_id = prizes.id)
    LEFT JOIN users ON (requests.user_id = users.id)";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="row mt-4">
            <div class="col table-responsive">
            <table class="table table-striped table-hover table-success">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Название акции</th>
                        <th>Имя приза</th>
                        <th>Имя пользователя</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= $row["promo_name"] ?></td>
                        <td><?= $row["prize_name"] ?></td>
                        <td><?= $row["login"] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
    
<?php endif; ?>

<?php if($t == "users") :
    $sql = "SELECT * FROM users ORDER BY id";
    $result = $pdo->query($sql);
    ?>
    <div class="row mt-4">
        <div class="col table-responsive">
        <table class="table table-striped table-hover table-info">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Логин</th>
                    <th>Пароль (хеш)</th>
                    <th>Аватарка</th>
                    <th>Права администратора</th>
                    <th>Баллы</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= $row["login"] ?></td>
                    <td><?= $row["password"] ?></td>
                    <td><?= $row["is_admin"] ?></td>
                    <td><?= $row["balance"] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
<?php endif; ?>

<?php if($t == "codes") : 
    $sql = "SELECT * FROM codes ORDER BY id";
    $result = $pdo->query($sql);
    ?>
        <form action="db/codegen-action.php" method="post" class="my-2" enctype="multipart/form-data">
            <p class="fs-3 my-0">Генератор кодов</p>

            <lable class="form-lable">Символы для генерации</lable>
            <input type="text" class="form-control" name="permitted_chars" value="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" required>

            <div class="row row-cols-2 row-cols-md-4 d-flex align-items-end ">
                <div class="col">
                    <lable class="form-lable">Количество кодов</lable>
                    <input type="number" class="form-control" name="count" required>
                </div>
                <div class="col">
                    <lable class="form-lable">Длина кодов</lable>
                    <input type="number" class="form-control" name="length" required>
                </div>
                <div class="col">
                    <lable class="form-lable">Минимальная цена</lable>
                    <input type="number" class="form-control" name="min_value" required>
                </div>
                <div class="col">
                    <lable class="form-lable">Максимальная цена</lable>
                    <input type="number" class="form-control" name="max_value" required>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 d-flex align-items-end">
                <div class="col"></div>
                <div class="col"></div>
                <div class="col">
                    <input class="btn bg-success-subtle border border-dark mt-4 w-100" type="submit" value="Сгенерировать" name="codegen_button">
                </div>
            </div>
        </form>
        <hr>
        <form action="db/codegen-action.php" method="post" class="my-2" enctype="multipart/form-data">
            <p class="fs-3 my-0">Добавить код</p>
            <div class="row row-cols-1 row-cols-md-3 d-flex align-items-end">
                <div class="col">
                    <lable class="form-lable">Введите код</lable>
                    <input type="text" class="form-control" name="new_code" required>
                </div>
                <div class="col">
                    <lable class="form-lable">Введите цену</lable>
                    <input type="number" class="form-control" name="new_value" required>
                </div>
                <div class="col">
                    <lable class="form-lable">ㅤ</lable>
                    <input class="btn bg-success-subtle border border-dark w-100" type="submit" value="Добавить код" name="codeadd_button">
                </div>
            </div>
        </form>
        <hr>
        <div class="row mt-4">
            <div class="col table-responsive">
            <table class="table table-striped table-hover table-success">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>code</th>
                        <th>value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= $row["code"] ?></td>
                        <td><?= $row["value"] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
<?php endif; ?>

</div>

<?php
    include ("parts/footer.php");
?>
