
	        	<div class="row">
	                	<div class="col-lg-12">
	                   		<h1 class="page-header">Make a deposit</h1>
	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->

	            	<div class="row">
	                	<div class="col-lg-12">

						<?
							//Секретный ключ интернет-магазина
							$key = "6273606158696238796763316a7c347c63334337637156714d6965";

							$fields = array();

							// Добавление полей формы в ассоциативный массив
							$fields["WMI_MERCHANT_ID"]    	= "106904256616";
							$fields["WMI_PAYMENT_AMOUNT"] 	= $sum;
							$fields["WMI_CURRENCY_ID"]    	= "840";
							$fields["WMI_PAYMENT_NO"]     	= $deposit_id;
							$fields["WMI_DESCRIPTION"]    		= "BASE64:".base64_encode("Payment for order #$deposit_id in Clanbets.com");
							$fields["WMI_SUCCESS_URL"]    	= "http://caxakrylov.dlinkddns.com/clanbets.com/user/deposit?check=success";
							$fields["WMI_FAIL_URL"]       		= "http://caxakrylov.dlinkddns.com/clanbets.com/user/deposit?check=fail";

							//Сортировка значений внутри полей
							foreach($fields as $name => $val)
							{
								if (is_array($val))
								{
									usort($val, "strcasecmp");
									$fields[$name] = $val;
								}
							}

							// Формирование сообщения, путем объединения значений формы,
							// отсортированных по именам ключей в порядке возрастания.
							uksort($fields, "strcasecmp");
							$fieldValues = "";

							foreach($fields as $value)
							{
								if (is_array($value))
									foreach($value as $v)
									{
										//Конвертация из текущей кодировки (UTF-8)
										//необходима только если кодировка магазина отлична от Windows-1251
										$v = iconv("utf-8", "windows-1251", $v);
										$fieldValues .= $v;
									}
								else
								{
									//Конвертация из текущей кодировки (UTF-8)
									//необходима только если кодировка магазина отлична от Windows-1251
									$value = iconv("utf-8", "windows-1251", $value);
									$fieldValues .= $value;
								}
							}

							// Формирование значения параметра WMI_SIGNATURE, путем
							// вычисления отпечатка, сформированного выше сообщения,
							// по алгоритму MD5 и представление его в Base64

							$signature = base64_encode(pack("H*", md5($fieldValues . $key)));
						?>


						<form action="https://www.walletone.com/checkout/default.aspx" method="POST" id="deposit"  role="form">

							<div class="form-group">
								<label class="label_amount">Amount $</label>

								<input type="text" readonly name="WMI_PAYMENT_AMOUNT" value="<?=$sum?>" class="inputamount" />
								<input type="hidden" name="WMI_SIGNATURE" value="<?=$signature?>" />
								<input type="hidden" name="WMI_MERCHANT_ID" value="106904256616" />
								<input type="hidden" name="WMI_CURRENCY_ID" value="840" />
								<input type="hidden" name="WMI_DESCRIPTION" value="<? echo "BASE64:".base64_encode("Payment for order #$deposit_id in Clanbets.com"); ?>" />
								<input type="hidden" name="WMI_PAYMENT_NO" value="<?=$deposit_id?>" />
								<input type="hidden" name="WMI_SUCCESS_URL" value="http://caxakrylov.dlinkddns.com/clanbets.com/user/deposit?check=success" />
								<input type="hidden" name="WMI_FAIL_URL" value="http://caxakrylov.dlinkddns.com/clanbets.com/user/deposit?check=fail" />
							</div>

							<button type="submit" class="btn btn-default" id="btn_deposit" name="btn_deposit">Deposit</button>
						</form>
						<div style="clear:both"></div>
						<div class="dline"></div>

	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->


