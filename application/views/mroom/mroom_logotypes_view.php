<h3>Логотипы команд</h3>

<p class="adm_notification">
	<? if (isset($ok)) { ?>
	Логотип успешно добавлен.
	<? } elseif (isset($errors)) { 
	foreach ($errors as $item) { ?>
	<?=$item?>
	<? }
	} ?>
</p>


<div>
	<form method="post" action="" enctype="multipart/form-data">
	<p>Введите клан-тег: <input type="text" name="name"></p>
	<p>Выберите иконку: <input type="file" name="icon" id="icon"/></p>
	<p><input type="submit" value="Добавить" name="submit" ></p>
	</form>
</div>

<table class="myedittable">
<?foreach($logotypes as $item){?>
	<tr>
	<td><img src="/src/img/uploads/<?=$item['icon']?>"/></td>
	<td><?=$item['name']?></td>
	<td><a href="/mroom/logotypes/delete/<?=$item['id']?>">Удалить</a></td>
	<td><a href="/mroom/logotypes/edit/<?=$item['id']?>">Редактировать</a></td>
	</tr>
<?}?>
</table>
