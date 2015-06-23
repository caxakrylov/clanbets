<h3>Добавить матч - выбор игроков</h3>
<div>
    <form method="post" action="">
        <p><?=$discipline->name ?>
          <select name="playerID1">
              <?foreach($players1 as $item) {?>
                <option value="<?=$item['id']?>"><?=$item['name']?></option>
              <?}?>
          </select>
          <select name="playerID2">
              <?foreach($players2 as $item) {?>
                <option value="<?=$item['id']?>"><?=$item['name']?></option>
              <?}?>
          </select>
        </p>

        <input type="submit" value="Продолжить" name="submit_step1"> 
    </form>
</div>