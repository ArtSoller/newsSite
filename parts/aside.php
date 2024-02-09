<aside class="col-12 col-lg-2 navbar-expand-lg navbar-light" id="sidebar">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent" 
        aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav nav nav-pills flex-column mb-auto my-4">
                <li class="nav-item">                        
                    <a href="index.php" class="nav-link" style="font-size: 1.1rem !important; padding: 0rem 0.5rem !important;">
                        Все
                    </a>
                </li>
                <li>
                    <a href="section-slick.php?section=1" class="nav-link" style="font-size: 1.1rem !important; padding: 0rem 0.5rem !important;">
                        Экономика
                    </a>
                </li>
                <li>
                    <a href="section-slick.php?section=2" class="nav-link" style="font-size: 1.1rem !important; padding: 0rem 0.5rem !important;">
                        Политика
                    </a>
                </li>
                <li>
                    <a href="section-slick.php?section=3" class="nav-link" style="font-size: 1.1rem !important; padding: 0rem 0.5rem !important;">
                        Наука
                    </a>
                </li>
                <li>
                    <a href="section-slick.php?section=4" class="nav-link" style="font-size: 1.1rem !important; padding: 0rem 0.5rem !important;">
                        Культура
                    </a>
                </li>
                <li>
                    <a href="section-slick.php?section=5" class="nav-link" style="font-size: 1.1rem !important; padding: 0rem 0.5rem !important;">
                        Спорт
                    </a>
                </li>
                <li>
                    <a href="promotions.php" class="nav-link" style="font-size: 1.1rem !important; padding: 0rem 0.5rem !important;">
                        Акции
                    </a>
                </li>
                <li>
                <?php if(isset($_SESSION["user"])) : ?>
                    <li><a class="nav-link" style="font-size: 1.1rem !important; padding: 0rem 0.5rem !important;" href="logout.php">Выйти</a></li>
                  <?php else:?>
                    <li><a class="nav-link" style="font-size: 1.1rem !important; padding: 0rem 0.5rem !important;" href="avtorization.php">Войти</a></li> <!--href="authorization.php" -->
                  <?php endif;?>
                </li>

            </ul>
        </div> 
    </div>                        
    <hr>            
</aside>