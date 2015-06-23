<h3>Редактирование флага</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Флаг успешно изменен.
		<? } elseif (isset($errors)) { 
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
    <form method="post" action="" enctype="multipart/form-data">
        <p>Введите код MOK страны: <input type="text" name="name" value="<?=$flag->name?>"></p>
        <p>Выберите иконку: <img src="/src/img/uploads/<?=$flag->icon?>"/> <input type="file" name="icon" id="icon" /></p>
        <p><input type="submit" value="Изменить" name="submit"></p>
    </form>
</div>
