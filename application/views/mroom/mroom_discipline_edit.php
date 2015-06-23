<h3>Редактирование дисциплины</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Дисциплина успешно изменена.
		<? } elseif (isset($errors)) {
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
    <form method="post" action="" enctype="multipart/form-data">
        <p>Введите название дисциплины: <input type="text" name="name" value="<?=$discipline->name?>"></p>
        <p>Введите короткое название дисциплины: <input type="text" name="shortname" value="<?=$discipline->shortname?>"></p>
        <p>Выберите иконку: <img src="/src/img/uploads/<?=$discipline->icon?>"/> <input type="file" name="icon" id="icon" /></p>
        <p><input type="submit" value="Изменить" name="submit"></p>
    </form>
</div>