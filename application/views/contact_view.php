<div id="<?= $id; ?>" class="container">
	<div class="row contact-block">
		<div class="item"><b>Имя: </b><span><?= $name; ?></span></div>
        <?php if(!empty($surname)) { ?>
			<div class="item">
				<b>Фамилия: </b><span><?= $surname; ?></span>
			</div>
		<?php } ?>
        <?php if(!empty($first_number)) { ?>
			<div class="item">
				<b>Номер 1: </b><span><?= $first_number; ?></span>
				<span>( <?= $num1_str; ?>)</span>
			</div>
        <?php } ?>
        <?php if(!empty($second_number)) { ?>
			<div class="item">
				<b>Номер 2: </b><span><?= $second_number; ?></span>
				<span>( <?= $num2_str; ?>)</span>
			</div>
        <?php } ?>
        <?php if(!empty($email)) { ?>
			<div class="item">
				<b>E-mail: </b><span><?= $email; ?></span>
			</div>
        <?php } ?>
        <?php if(!empty($image)) { ?>
			<div class="item-image">
				<img src="<?= '/' . UPLOADS_PATH . $image; ?>" class="image-big" alt="ups"/>
			</div>
        <?php } ?>
	</div>
	<button id="btn-contact-to-update" type="button" class="btn btn-primary">Редактировать</button>
	<button id="btn-contact-delete" type="button" class="btn btn-primary">Удалить контакт</button>
</div>