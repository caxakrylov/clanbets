<h3>Редактирование логотипа</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Логотип успешно изменен.
		<? } elseif (isset($errors)) { 
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
    <form method="post" action="" enctype="multipart/form-data">
        <p>Введите клан-тег: <input type="text" name="name" value="<?=$logotype->name?>"></p>
        <p>Выберите иконку: <img src="/src/img/uploads/<?=$logotype->icon?>"/> <input type="file" name="icon" id="icon" /></p>
        <p><input type="submit" value="Изменить" name="submit"></p>
    </form>
</div>
