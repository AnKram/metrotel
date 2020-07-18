<?php
$id = 'class="' . $id . '"';
$name = 'value="' . $name . '"';
$surname_val = (!empty($surname)) ? 'value="' . $surname . '"' : '';
$num1_val = (!empty($first_number)) ? 'value="' . $first_number . '"' : '';
$num2_val = (!empty($second_number)) ? 'value="' . $second_number . '"' : '';
$email_val = (!empty($email)) ? 'value="' . $email . '"' : '';
$image_val = (!empty($image)) ? 'value="' . $image . '"' : '';
?>
<div class="container">
	<div class="row">
        <?php if (!empty($title)) { ?>
			<h3><?= $title; ?></h3>
        <?php } ?>
	</div>
	<div class="row">
		<form id="contact-form" <?= $id; ?>>
			<div class="form-group">
				<label for="name">Имя</label>
				<input type="text" class="form-control" id="name" <?= $name; ?> aria-describedby="loginHelp" placeholder="Имя">
			</div>
			<div class="form-group">
				<label for="surname">Фамилия</label>
				<input type="text" class="form-control" id="surname" <?= $surname_val; ?> aria-describedby="emailHelp" placeholder="Фамилия">
			</div>
			<div class="form-group">
				<label for="num1">Номер 1</label>
				<input type="text" class="form-control" id="num1" <?= $num1_val; ?> placeholder="Номер">
			</div>
			<div class="form-group">
				<label for="num2">Номер 2</label>
				<input type="text" class="form-control" id="num2" <?= $num2_val; ?> placeholder="Номер">
			</div>
			<div class="form-group">
				<label for="email">Почта</label>
				<input type="email" class="form-control" id="email" <?= $email_val; ?> aria-describedby="emailHelp" placeholder="Почта">
			</div>
			<div class="form-group">
				<label for="file">Фото (не больше 2Мб, форматы: jpg/png)</label>
				<input type="file" class="form-control-file" id="file">
			</div>
			<div id="fileError" class="error"></div>
			</br>
			<button id="btn-contact-<?= $action; ?>" type="button" class="btn btn-primary">
				<?php echo $action == 'create' ? 'Создать' : 'Обновить'; ?>
			</button>
		</form>
	</div>
</div>