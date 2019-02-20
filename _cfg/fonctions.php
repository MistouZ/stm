<?php

function enleverCaracteresSpeciaux($text) {
$utf8 = array(
'/[АЮБЦ╙Д]/u' => 'a',
'/[аюбцд]/u' => 'A',
'/[млно]/u' => 'I',
'/[МЛНО]/u' => 'i',
'/[ИХЙК]/u' => 'e',
'/[ихйк]/u' => 'E',
'/[СРТУ╨Ж]/u' => 'o',
'/[сртуж]/u' => 'O',
'/[ЗЫШЭ]/u' => 'u',
'/[зышэ]/u' => 'U',
'/Г/' => 'c',
'/г/' => 'C',
'/Я/' => 'n',
'/я/' => 'N',
'//' => '-', // conversion d'un tiret UTF-8 en un tiret simple
'/[]/u' => ' ', // guillemet simple
'/[╚╩]/u' => ' ', // guillemet double
'/ /' => ' ', // espace insИcable (Иquiv. Ю 0x160)
);
return preg_replace(array_keys($utf8), array_values($utf8), $text);
}

function transformerEnURL($string) {
return strtolower(preg_replace(array( '#[s-]+#', '#[^A-Za-z0-9. -]+#' ), array( '-', '' ), enleverCaracteresSpeciaux(str_replace(array_keys($dict), array_values($dict), urldecode($string)))));
}


?>