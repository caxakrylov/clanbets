<h3>Проверка почты</h3>

	<p class="adm_notification">
		<? if (isset($ok)) { ?>
		Тестовое письмо успешно отправленно
		<? } elseif (isset($errors)) { 
		foreach ($errors as $item) { ?>
		<?=$item?>
		<? }
		} ?>
	</p>

<div>
	<form method="post" action="" enctype="multipart/form-data">
	<p>Email для отправки тестового письма: <input type="text" name="email"></p>
	<p><input type="submit" value="Отправить" name="submit" ></p>
	</form>
</div>

