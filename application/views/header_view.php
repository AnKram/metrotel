<header>
    <div class="container">
        <div class="row" style="padding: 20px 0">
            <div class="col-8 align-center" style="padding-left: 0">
                <?php if (!empty($_SESSION['user_id'])) { ?>
                    <a href="/contacts"><h2>Телефонная книга</h2></a>
                <?php } else { ?>
                    <h2>Телефонная книга</h2>
                <?php } ?>
            </div>
            <div class="col-2 align-center">
                <?php if(!empty($_SESSION['user_login'])) { ?>
                    <b>Логин: <?= $_SESSION['user_login'] ?></b>
                <?php } ?>
            </div>
            <div class="col-2 align-center">
				<?php if(!empty($_SESSION['user_id'])) { ?>
                    <button id="btn-exit" type="button" class="btn btn-primary">Выйти</button>
                <?php } ?>
            </div>
        </div>
    </div>
</header>