<h3>Редактирование игрока</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Игрок успешно изменен.
		<? } elseif (isset($errors)) { 
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
    <form method="post" action="" enctype="multipart/form-data">
        <p>Введите nickname игрока: <input type="text" name="name" value="<?=$player->name?>"></p>
        <p>Выберите команду: 
          <select name="teamID">
              <?foreach($teams as $item) {?>
                <option <?if ($item->id == $player->teamID) echo "selected";?> value="<?=$item->id?>" style="background: url(/src/img/uploads/<?=$item->discipline->icon?>) no-repeat right; padding:3px 24px 3px 3px;"><?=$item->name?></option>
              <?}?>
          </select>
        </p>
        <input type="submit" value="Изменить" name="submit"> 
    </form>
</div>

