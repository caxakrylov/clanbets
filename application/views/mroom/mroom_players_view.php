
<h3>Игроки</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Игрок успешно добавлен.
		<? } elseif (isset($errors)) { 
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
	<form method="post" action="" enctype="multipart/form-data">
	<p>Введите nickname игрока: <input type="text" name="name"></p>
	<p>Выберите команду: 
	<select name="teamID">
	<?foreach($teams as $item) {?>
	<option value="<?=$item->id?>" style="background: url(/src/img/uploads/<?=$item->discipline->icon?>) no-repeat right; padding:3px 24px 3px 3px;"><?=$item->name?></option>
	<?}?>
	</select>
	</p>
	<input type="submit" value="Добавить" name="submit">
	</form>
</div>

<table class="myedittable">
<?foreach($players as $item){?>
	<tr>
	<td><?=$item->team->shortname?></td>  
	<td><?=$item->name?></td>
	<td><img src="/src/img/uploads/<?=$item->team->discipline->icon?>"/></td>   
	<td><a href="/mroom/players/delete/<?=$item->id?>">Удалить</a></td>
	<td><a href="/mroom/players/edit/<?=$item->id?>">Редактировать</a></td>
	</tr>
<?}?>
</table>
