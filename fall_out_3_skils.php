<?php

/*
* 
* Входными данными явдяется массив $special, в котором хранятся исходные значения всех скилов,
* и SCORES - константа, в которой хранится сумма максимального кол-ва скилов.
* Выходными данными является массив $special, в нем хранятся все значения силы, выносливости и т.д.
* героя, а так же переменная $person которой хранится пол и имя персонажа.
* В этом коментрарии я изменил этот код потому что нужно
*
*/

define('SCORES', 40);
$special = [
	'Strength'    => 1,
	'Perception'  => 1,
	'Endurance'   => 1,
	'Charisma'    => 1,
	'Inteligence' => 1,
	'Agility'     => 1,
	'Luck'        => 1
];

echo "Generate character? 1 or 0\n";  //Выбор - автоматическая генерация или ручная 
$input = input($input);



if($input == 1){
	$out_person = auto_special($special); // Вызов функции автоматической генерации
	$person = $out_person[0];
	$special = $out_person[1];
}
else{
	$out_person = user_special($special); // Вызов функции ручной генерации
	$person = $out_person[0];
	$special = $out_person[1];
}

echo $person. "\n";
print_r($special);



function user_special($special){           // Функция ручной генерации
	echo "Enter the sex(1 - man, 0 - woman), name and sername your charaster:\n";
	$input = input($input);
	$person = explode(' ',trim($input));
	if($person[0] == 1){
		$person[0] == 'Man';
	}
	else{
		$person[0] == 'Woman';
	}
	$person = $person[0]. " - ". ucfirst($person[1]). " ". ucfirst($person[2]);
	foreach($special as $key => $val){
		echo($key." = ". $val). ", ";
	}
	echo "\n";
	$special = spec($special);
	if(array_sum($special) != SCORES){
		echo"Re-distribute please\n";
		$special = spec($special);        
	}

	$out_person[0] = $person;
	$out_person[1] = $special;
	return $out_person;
}

function spec($special){                   // Функция расчета спешл
	foreach($special as $key => $val){
		if(array_sum($special) >= SCORES){
			break;
		}
		echo "Enter the skil ". strtoupper($key). " = ". $val . ", (1..9) left ". ((SCORES) - array_sum($special)). ":\n";	
		$b_in = input($input);
		if($b_in + array_sum($special) > SCORES)
		{
			echo "ERROR! An incorrect number!\n";
			$special[$key] += ((SCORES) - array_sum($special)); 
			break;
		}
		else{
			if(($b_in > 9 || $b_in < 0) || (($val + $b_in) > 10)){
				echo "ERROR! Is not correct, please re-enter the skil ". strtoupper($key). " = ". $val  . ", (1..9) left ". (SCORES - array_sum($special)). ":\n";
				$b_in = input($input);
			}
			else{
				$special[$key] += $b_in;
			}
		}	
	}
	return $special;
}

function auto_special($special){           // Функция автоматической генерации
	$person_man = ['Ivan', 'Pavlo', 'Luntik', 'Evkakiy', 'Paranoik'];
	$sername_man = ['Kal', 'Lal', 'Pol', 'Til', 'Wol'];
	$person_woman = ['Sonya', 'Irka', 'Dirka', 'Paraska', 'Lola'];
	$sername_woman = ['Kala', 'Lala', 'Pola', 'Tila', 'Wola'];
	if(rand(0,1) == 0){
		$person = "man - ".$person_man[rand(0,4)]." ". $sername_man[rand(0,4)];
	}
	else{
		$person = "woman - ".$person_woman[rand(0,4)]." ". $sername_woman[rand(0,4)];
	}
	
	while(array_sum($special) < SCORES){
		$a = array_rand($special);
		$b = rand(1,9);
		//$b = 1;
		if(SCORES - array_sum($special) < 10){
			$b = rand(1 , SCORES - array_sum($special));			
		}
		if(($special[$a] + $b) <= 10){
			$special[$a] += $b;
		}
	}
	$out_person[0] = $person;
	$out_person[1] = $special;
	return $out_person;
}

function input($input){                  // Функция чтения данных из консоли
	$input = fopen ("php://stdin","r");
	$input = fgets($input);
	return $input;
}