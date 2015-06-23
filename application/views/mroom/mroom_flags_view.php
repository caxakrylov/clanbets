<h3>Национальные флаги команд</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Флаг успешно добавлен.
		<? } elseif (isset($errors)) { 
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
	<form method="post" action="" enctype="multipart/form-data">
	<p>Введите код MOK страны: <input type="text" name="name"></p>
	<p>Выберите иконку: <input type="file" name="icon" id="icon"/></p>
	<p><input type="submit" value="Добавить" name="submit" ></p>
	</form>
</div>

<table class="myedittable">
<?foreach($flags as $item){?>
	<tr>
	<td><img src="/src/img/uploads/<?=$item['icon']?>"/></td>
	<td><?=$item['name']?></td>
	<td><a href="/mroom/flags/delete/<?=$item['id']?>">Удалить</a></td>
	<td><a href="/mroom/flags/edit/<?=$item['id']?>">Редактировать</a></td>
	</tr>
<?}?>
</table>
