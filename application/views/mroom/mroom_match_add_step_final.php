<h3>Добавить матч - завершение</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Матч успешно добавлен.
		<? } elseif (isset($errors)) {
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
    <form method="post" action="" style="font-size:11px;">
      <table class="myedittable">
          <tr style="font-weight:bold;">
            <td>Дисциплина</td>
            <td>Участник №1</td>
            <td>Коэфф. №1</td>
            <td>Участник №2</td>
            <td>Коэфф. №2</td>
            <td>Коэфф. ничьи</td>
            <td>Best of</td>
            <td>Ивент</td>
            <td>Дата и время матча CET</td>
            <td>Макс. ставка</td>
          </tr>

          <tr>
            <td><?=$discipline->name?></td>
            <td><?=$team1->shortname?><br/><span><?=$player1->name?></span></td>
            <td><?=$rate1?></td>
            <td><?=$team2->shortname?><br/><span><?=$player2->name?></span></td>
            <td><?=$rate2?></td>
            <td><?=$draw?></td>
            <td><?=$bestof?></td>
            <td>
              <select name="eventID">
                <?foreach($events as $item) {?>
                  <option
                    <? if (isset($event) ){
                      if ($event == $item->id){
                        echo "selected";
                      }
                    } ?>
                  value="<?=$item->id?>"><?=$item->name?></option>
                <?}?>
              </select>
            </td>
            <td><input type="text" name="datetime" id="datetime" <?
                date_default_timezone_set('CET'); //В единственном месте здесь стоит CET для удобства и наглядности.
                if (isset($datetime)) {echo "value='$datetime'";} else {echo "value='".date('d.m.Y H:i',time())."'";} ?>  ></td>
            <td><?=$maxbet?></td>
          </tr>
        </table>

        <input type="submit" value="Добавить матч" name="submit_final">
    </form>
</div>


<script type="text/javascript">

  $(document).ready(function(){
    // $("#datetime").datetimeEntry({datetimeFormat: 'D-O-Y H:M', minDatetime: -300, maxDatetime: '+10d', spinnerImage: ''});
    $("#datetime").datetimeEntry({datetimeFormat: 'D.O.Y H:M', maxDatetime: '+10d', spinnerImage: ''});
  });

</script>