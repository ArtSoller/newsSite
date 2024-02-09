<?php
include 'action/connect.php';

include ("parts/header.php");

if (!isset($_SESSION['user'])) : ?>

<main>
    <div class="container text-center">
        <p class="fw-bold fs-2 my-5">Раздел Акции доступен только зарегистрированным пользователям</p>
    </div>
</main>

<?php else : 
date_default_timezone_set('Asia/Novosibirsk');

$sql = "SELECT balance FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $_SESSION['user']['id']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$balance = $result['balance'];

$current_datetime = date('Y-m-d H:i:s');
?>

<main class="d-lg-flex">
        <?php
            include 'parts/aside.php';
        ?>
        <div class="col-12 col-lg-7">

        <div class="d-flex justify-content-around mt-3 align-items-center">
            <div class="balance">
                <span class="fw-bold">Ваши баллы: </span> <span class="text-primary fw-bold"> <?= $balance ?> </span>
                <?php $file = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y"));
 
            $xml = $file->xpath("//Valute[@ID='R01235']");
            $valute_usd = strval($xml[0]->Value);
            echo '<p class="text-primary fw-bold" style = "margin-bottom: 0px;"> USD ' .$valute_usd; // получим курс доллара
            
            $xml = $file->xpath("//Valute[@ID='R01239']");
            $valute_euro = strval($xml[0]->Value);
            echo '<p class="text-primary fw-bold"> EUR ' .$valute_euro; // получим курс евро
            ?>
            </div>
            
    
            <form action="action/plus-action.php" method="post" class="d-inline-flex">
                <input type="text" name="code" size="12" class="form-control">
                <input type="hidden" name="value" value=" <?= 12 ?>">
                <input type="hidden" name="login" value=" <?= $_SESSION['user']['login'] ?>">
                <input class="btn btn-success mx-1" type="submit" value="Активировать код" name="plus-button">
            </form>
        </div>
        
        <div class="col-12 col-md-10 col-lg-8 mx-auto">
            <?php

            if (!empty($_SESSION['message']))
            echo '<p class="bg-info text-center rounded-2 mt-4 p-2">' . $_SESSION['message'].'</p>';
            unset($_SESSION['message']);

            $sql = "SELECT * FROM promos1 ORDER BY promo_datetime DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $promos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($promos as $promo) : 

                $isLate = false;
                if ($current_datetime > $promo["promo_datetime"])
                    $isLate = true;

                $sql = "SELECT * FROM prizes WHERE promo_id=:promo_id ORDER BY prize_price DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":promo_id", $promo["id"]);
                $stmt->execute();

                $prizes = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>
                
                <div class="card my-4 border border-primary border-2">
                    <div class="card-header text-center border-secondary">
                        <p class="card-text text-dark fw-bold fs-5"> <?= $promo["promo_name"] ?> </p>
                    </div>
                    <div class="card-body text-center">
                        <p> <?= $promo["promo_description"] ?> </p>
                        <div class="row row-cols-1 row-cols-md-2 g-3">

                            <?php foreach ($prizes as $prize) : 
                                
                                $sql = "SELECT count(*) FROM requests WHERE prize_id=:prize_id";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindValue(":prize_id", $prize['id']);
                                $stmt->execute();
                                $count = $stmt->fetch();
                                $count = $count[0];

                                ?>
                                
                                <div class="col">
                                    <div class="card zoom">
                                        <div class="card-header text-center fw-bold">
                                            <span><?= $prize["prize_name"] ?></span>
                                        </div>
                                        <div class="card-body" style="position:relative;">
                                            <img src="<?= $prize["cover"] ?>" class="card-img" style="width: auto; max-height: 200px; max-width: 100%" alt="Обложка новости">
                                            <div class="bg-white rounded-3 p-2" style="position: absolute; top: 0; left: 0;">
                                            <?php if (!$isLate): ?>
                                                <p class="card-text mb-0">Цена: <span class="card-text mb-0 fw-bold text-success"><?= $prize["prize_price"] ?></span></p> 
                                            <?php endif; ?>
                                                <p class="card-text mb-0">Заказов: <span class="card-text mb-0 fw-bold text-warning"><?= $count?></span></p>
                                            </div>
                                            
                                            
                                        </div>
                                        <?php if (!$isLate): ?>
                                        <div class="card-footer p-0">
                                        <form action="action/request-action.php" method="post">
                                            <input type="hidden" name="promo_datetime" value=" <?= $promo["promo_datetime"] ?>">
                                            <input type="hidden" name="prize_id" value="<?= $prize["id"] ?>">
                                            <input type="hidden" name="prize_price" value="<?= $prize["prize_price"] ?>">
                                            <input type="hidden" name="promo_id" value="<?= $promo["id"] ?>">
                                            <input type="submit" value="Заказать товар" name="request_button" class=" <?php if ($balance < $prize["prize_price"]) echo "disabled" ?> btn btn-primary w-100 rounded-0 rounded-bottom-1">
                                        </form>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php endforeach ?>

                        </div>

                    </div>
                    <div class="card-footer text-center border-primary">

                        <?php 

                            if ($isLate)
                                echo "<span>Акция окончена</span>";
                            else
                            echo "<span>Дата окончания акции: " . DateTime::createFromFormat('Y-m-d H:i:s', $promo["promo_datetime"])->format('d.m.Y H:i:s')  . " по НСК</span>";
                        
                        ?>
                        
                    </div>
                </div>

            <?php endforeach;?>

        </div>
    </div>
                                        </div>
</main>

<?php endif;

// include 'parts/footer.php';

?>