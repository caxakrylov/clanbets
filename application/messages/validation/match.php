<?
return array(
	'rate1' => array(
		'not_empty' => 'Не указан коэффициент на победу первого участника',
		'max_length' => 'Максимальная длина коэффициента 5 символов',
		'decimal' => 'Коэффициент должен быть дробным, в виде x.xxx',
	),
	'rate2' => array(
		'not_empty' => 'Не указан коэффициент на победу второго участника',
		'max_length' => 'Максимальная длина коэффициента 5 символов',
		'decimal' => 'Коэффициент должен быть дробным, в виде x.xxx',
	),
	'draw' => array(
		'not_empty' => 'Не указан коэффициент на ничейный результат',
		'max_length' => 'Максимальная длина коэффициента 5 символов',
		'decimal' => 'Коэффициент должен быть дробным, в виде x.xxx',
	),
	'maxbet' => array(
		'not_empty' => 'Не указан максимальный размер ставки',
		'max_length' => 'Длина максимальной ставки не должна превышать 5 символов',
		'numeric' => 'Коэффициент должны быть целым числом',
	),	
	'datetime' => array(
		'not_empty' => 'Укажите дату и время матча',
		'numeric' => 'Некорректная дата',
	),
	'bestof' => array(
		'not_empty' => 'Bestof не указано количество',
		'numeric' => 'Bestof должен быть числом',		
		'max_length' => 'Bestof максимальная длина 2 цифры',
	),
);