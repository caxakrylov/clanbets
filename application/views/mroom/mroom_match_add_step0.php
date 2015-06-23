<h3>Матчи</h3>
	<p class="adm_notification">
		<? if (isset($_SESSION['okaddmatch'])) { ?>
		Матч успешно добавлен.
		<? 
		unset($_SESSION['okaddmatch']);
		} elseif (isset($errors)) { 
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>
<div>
    <form method="post" action="/mroom/matches/addmatch">
        <p>
          <select name="disciplineID">
              <?foreach($disciplines as $item) {?>
                <option value="<?=$item->id?>"><?=$item->name?></option>
              <?}?>
          </select>
        </p>

        <input type="submit" value="Добавить" name="submit"> 
    </form>
</div>