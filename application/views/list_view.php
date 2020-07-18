<div class="container">
	<div id="btns-block" class="row">
		<div class="col-3">
			<button id="btn-new" type="button" class="btn btn-primary">Новая запись</button>
		</div>
		<div class="col-3">
            <?php if (!empty($sort) && !empty($sort_selected)) { ?>
				<select id="inputSort" class="form-control">
					<?php foreach ($sort as $sort_val => $sort_name) { ?>
						<option value="<?= $sort_val; ?>" <?php if($sort_val === $sort_selected) echo 'selected'; ?>><?= $sort_name; ?></option>
					<?php } ?>
				</select>
            <?php } ?>
		</div>
		<div class="col-3">
            <?php if (!empty($sequence) && !empty($sequence_selected)) { ?>
				<select id="inputSequence" class="form-control">
					<?php foreach ($sequence as $sequence_val => $sequence_name) { ?>
						<option value="<?= $sequence_val; ?>" <?php if($sequence_val === $sequence_selected) echo 'selected'; ?>><?= $sequence_name; ?></option>
					<?php } ?>
				</select>
            <?php } ?>
		</div>
		<div class="col-3">
			<!--<button id="btn-sort" type="button" class="btn btn-primary">Сортировать</button>-->
			<button id="btn-sort-ajax" type="button" class="btn btn-primary">Сортировать</button>
		</div>
	</div>
	<div class="row">
		<h3>Список контактов</h3>
		<div id="contacts-block" class="contacts-block">
			<?php if (!empty($list)) { ?>
				<?php foreach ($list as $contact) { ?>
					<div class="row contact">
						<div class="col-8">
							<span class="name"><?= $contact['name']; ?></span>
							<?php if(!empty($contact['surname'])) { ?>
								<span class="surname"><?= $contact['surname']; ?></span>
							<?php } ?>
							<?php if(!empty($contact['first_number'])) { ?>
								<span class="num1"><?= $contact['first_number']; ?></span>
							<?php } ?>
							<?php if(!empty($contact['image'])) { ?>
								<img src="<?= '/' . UPLOADS_PATH . $contact['image']; ?>" class="image" alt="ups"/>
							<?php } ?>
						</div>
						<div class="col-4">
							<button id="<?= $contact['id']; ?>" type="button" class="btn btn-primary btn-open-contact">Подробнее</button>
						</div>
					</div>
				<?php } ?>
			<?php } else { ?>
				<p>Список пуст</p>
            <?php } ?>
		</div>
	</div>
</div>