<h3>Команды</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Команда успешно добавлена.
		<? } elseif (isset($errors)) { 
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
	<form method="post" action="" enctype="multipart/form-data">
	<p>Введите название команды: <input type="text" name="name"></p>
	<p>Введите сокращенное название: <input type="text" name="shortname"></p>        
	<p>Выберите логотип команды: 
	<select name="logotypeID">
	<?foreach($logotypes as $item) {?>
	<option value="<?=$item['id']?>"><?=$item['name']?></option>
	<?}?>
	</select>
	</p>
	<p>Выберите национальный флаг команды:          
	<select name="flagID">
	<?foreach($flags as $item) {?>
	<option value="<?=$item['id']?>"><?=$item['name']?></option>
	<?}?>
	</select>
	</p>        
	<p>Выберите дисциплину для команды:
	<select name="disciplineID">
	<?foreach($disciplines as $item) {?>
	<option value="<?=$item->id?>"><?=$item->name?></option>
	<?}?>
	</select>
	</p>
	<input type="submit" value="Добавить" name="submit"> 
	</form>
</div>

<table class="myedittable">

<?
foreach($disciplines as $itemdisc){
?>
	<tr style='border-bottom:1px solid #ccc;'>
		<td colspan="6" style="text-align:center;"><?=$itemdisc->name?> <img src="/src/img/uploads/<?=$itemdisc->icon?>"/></td>
	</tr>
<?
	foreach($teams as $itemteam){
		if ($itemdisc->id == $itemteam->disciplineID)
		{ 
?>
			<tr>
				<td><?=$itemteam->name?></td>
				<td><?=$itemteam->shortname?></td>    
				<td><img src="/src/img/uploads/<?=$itemteam->logotype->icon?>"/></td> 
				<td><img src="/src/img/uploads/<?=$itemteam->flag->icon?>"/></td> 
				<td><a href="/mroom/teams/delete/<?=$itemteam->id?>">Удалить</a></td>
				<td><a href="/mroom/teams/edit/<?=$itemteam->id?>">Редактировать</a></td>
			</tr>
<?
		}
	}
}
?>
</table>
