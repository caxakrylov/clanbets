<h3>Добавить матч - выбор команды</h3>
<div>
    <form method="post" action="">
        <p><?=$discipline->name?>
          <select name="teamID1">
              <?foreach($teams as $item) {?>
                <option value="<?=$item['id']?>"><?=$item['name']?></option>
              <?}?>
          </select>
          <select name="teamID2">
              <?foreach($teams as $item) {?>
                <option value="<?=$item['id']?>"><?=$item['name']?></option>
              <?}?>
          </select>
          Игроки?
          <input type="checkbox" name="checkplayers" value="1">
        </p>

        <input type="submit" value="Продолжить" name="submit_step1"> 
    </form>
</div>