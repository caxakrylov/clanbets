<h3>Игровые ивенты</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Ивент успешно добавлен.
		<? } elseif (isset($errors)) { 
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
	<form method="post" action="" enctype="multipart/form-data">
	<p>Введите название ивента: <input type="text" name="name"></p>
	<p><input type="submit" value="Добавить" name="submit" ></p>
	</form>
</div>

<table class="myedittable">
<?foreach($events as $item){?>
	<tr>
	<td><?=$item->name?></td>
	<td><a href="/mroom/events/delete/<?=$item->id?>">Удалить</a></td>
	<td><a href="/mroom/events/edit/<?=$item->id?>">Редактировать</a></td>
	</tr>
<?}?>
</table>
