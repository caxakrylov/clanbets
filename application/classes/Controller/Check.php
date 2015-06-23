<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Check extends MController {

	public $template = 'user/base';

	public function action_mail() //valid, -, id, +
	{
		$hash = $this->request->param('id');
		$data = array();

		if (Valid::max_length($hash, 18) && Valid::min_length($hash, 18) && Valid::not_empty($hash) && Valid::alpha_numeric($hash)) {

			$msignup = new Model_Signup();

			if($msignup->checkmail($hash))
			{
				$data["ok"] = "";
			}
			else
			{
				$data["error"] = "";
			}
		} else {
			$data["error"] = "";
		}

		$this->template->content =  View::factory('user/checkmail_view', $data);
		$this->template->js = View::factory('user/checkmail_view_js');
		$this->template->css = View::factory('user/index_view_css');
	}


	public function action_termsofuse() //valid, -, id
	{
		$this->template->content =  View::factory('user/termsofuse_view');
		$this->template->js = View::factory('user/termsofuse_view_js');
		$this->template->css = View::factory('user/index_view_css');
	}


	public function action_checkdeposit()
	{
		// Секретный ключ интернет-магазина (настраивается в кабинете)
		$skey = "6273606158696238796763316a7c347c63334337637156714d6965";

		// Функция, которая возвращает результат в Единую кассу
		function print_answer($result, $description)
		{
			print "WMI_RESULT=" . strtoupper($result) . "&";
			print "WMI_DESCRIPTION=" .urlencode($description);
			exit();
		}

		// Проверка наличия необходимых параметров в POST-запросе
		if (!isset($_POST["WMI_SIGNATURE"]))
			print_answer("Retry", "Отсутствует параметр WMI_SIGNATURE");

		if (!isset($_POST["WMI_PAYMENT_NO"]))
			print_answer("Retry", "Отсутствует параметр WMI_PAYMENT_NO");

		if (!isset($_POST["WMI_ORDER_STATE"]))
			print_answer("Retry", "Отсутствует параметр WMI_ORDER_STATE");

		// Извлечение всех параметров POST-запроса, кроме WMI_SIGNATURE

		foreach($_POST as $name => $value)
		{
			if ($name !== "WMI_SIGNATURE") $params[$name] = $value;
		}

		// Сортировка массива по именам ключей в порядке возрастания
		// и формирование сообщения, путем объединения значений формы
		uksort($params, "strcasecmp"); $values = "";

		foreach($params as $name => $value)
		{
			//Конвертация из текущей кодировки (UTF-8)
			//необходима только если кодировка магазина отлична от Windows-1251
			$value = iconv("utf-8", "windows-1251", $value);
			$values .= $value;
		}

		// Формирование подписи для сравнения ее с параметром WMI_SIGNATURE

		$signature = base64_encode(pack("H*", md5($values . $skey)));

		//Сравнение полученной подписи с подписью W1

		if ($signature == $_POST["WMI_SIGNATURE"])
		{
			$mres = new Model_Resources();

			if (strtoupper($_POST["WMI_ORDER_STATE"]) == "ACCEPTED")
			{
				// TODO: Пометить заказ, как «Оплаченный» в системе учета магазина
				if ($mres->change_state_deposit($_POST["WMI_PAYMENT_NO"], 5))
					print_answer("Ok", "!Заказ #" . $_POST["WMI_PAYMENT_NO"] . " оплачен!");
				else
					print_answer("Retry", "!Попытка повторного зачисления платежа, уже успешно зачисленного. Либо Ошибка сохранения изменений Success(5).". $_POST["WMI_ORDER_STATE"]);
			}
			else
			{
				// Случилось что-то странное, пришло неизвестное состояние заказа
				if ($mres->change_state_deposit($_POST["WMI_PAYMENT_NO"], 6))
					print_answer("Retry", "!Неверное состояние ". $_POST["WMI_ORDER_STATE"]);
				else
					print_answer("Retry", "!Ошибка сохранения изменений Failure(6) /check/checkdeposit ". $_POST["WMI_ORDER_STATE"]);
			}
		}
		else
		{
			// Подпись не совпадает, возможно вы поменяли настройки интернет-магазина
			print_answer("Retry", "!Неверная подпись " . $_POST["WMI_SIGNATURE"]);
		}
	}



}
