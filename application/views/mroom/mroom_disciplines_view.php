
<h3>Игровые дисциплины</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Дисциплина успешно добавлена.
		<? } elseif (isset($errors)) {
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
	<form method="post" action="" enctype="multipart/form-data">
	<p>Введите дисциплину: <input type="text" name="name"></p>
	<p>Введите короткое название: <input type="text" name="shortname"></p>
	<p>Выберите иконку: <input type="file" name="icon" id="icon"/></p>
	<p><input type="submit" value="Добавить" name="submit" ></p>
	</form>
</div>

<table class="myedittable">
<?foreach($disciplines as $item){?>
	<tr>
	<td><img src="/src/img/uploads/<?=$item->icon?>"/></td>
	<td><?=$item->name?> (<?=$item->shortname?>)</td>
	<td><a href="/mroom/disciplines/delete/<?=$item->id?>">Удалить</a></td>
	<td><a href="/mroom/disciplines/edit/<?=$item->id?>">Редактировать</a></td>
	</tr>
<?}?>


</table>
