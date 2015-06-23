<h3>Редактирование ивента</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Ивент успешно изменен.
		<? } elseif (isset($errors)) { 
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
    <form method="post" action="" enctype="multipart/form-data">
        <p>Введите название ивента: <input type="text" name="name" value="<?=$event->name?>"></p>
        <p><input type="submit" value="Изменить" name="submit"></p>
    </form>
</div>