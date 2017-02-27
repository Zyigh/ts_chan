<?php
try{
    $pdo = new PDO('mysql:dbname=ts_chan;host=localhost;port=8888','root','root');
} catch(PDOException $exception) {
    die($exception->getMessage());
}
$pdo->exec("SET NAMES UTF8");

/**
//La fonction Taylor Swift affiche une vérité générale
//@return : var_dump
*/

function taylorSwift()
{
	var_dump('Taylor Swift est la plus belle du monde <3');
};

/**
//@param : $_GET || $_POST
//@return : array
//prends toutes les valeurs dans $_GET et $_POST
//les mets en htmlspecialchars
*/
function secureGet($array) 
{
	foreach ($array as $key => $value) 
	{
		$array[$key] = htmlspecialchars($value);
		$array[$key] = htmlentities($value);
	}
	return $array;
};

/**
//@param = date(c)
//pour afficher en 
// 'yyyy/mm/dd hh:mm:ss'
*/
function formatDate($string)
{
	$string = strtr($string, 'T', ' ');
	$string = substr($string, 0, 19);
	return $string;	
};
