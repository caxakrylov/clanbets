<h3>Редактирование команды</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Команда успешно изменена.
		<? } elseif (isset($errors)) { 
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
    <form method="post" action="" enctype="multipart/form-data">
        <p>Введите название команды: <input type="text" name="name" value="<?=$team->name?>"></p>
        <p>Введите сокращенное название: <input type="text" name="shortname" value="<?=$team->shortname?>"></p>        
        <p>Выберите логотип команды: 
          <select name="logotypeID">
              <?foreach($logotypes as $item) {?>
                <option <?if ($item['id'] == $team->logotypeID) echo "selected";?> value="<?=$item['id']?>"><?=$item['name']?></option>
              <?}?>
          </select>
          <img src="/src/img/uploads/<?=$team->logotype->icon?>"/>
        </p>
        <p>Выберите национальный флаг команды:          
          <select name="flagID">
              <?foreach($flags as $item) {?>
                <option <?if ($item['id'] == $team->flagID) echo "selected";?> value="<?=$item['id']?>"><?=$item['name']?></option>
              <?}?>
          </select>
          <img src="/src/img/uploads/<?=$team->flag->icon?>"/>
        </p>
        <p>Выберите дисциплину для команды:
          <select name="disciplineID">
              <?foreach($disciplines as $item) {?>
                <option <?if ($item->id == $team->disciplineID) echo "selected";?> value="<?=$item->id?>"><?=$item->name?></option>
              <?}?>
          </select>
          <img src="/src/img/uploads/<?=$team->discipline->icon?>"/>
        </p>
        <input type="submit" value="Изменить" name="submit"> 
    </form>
</div>

