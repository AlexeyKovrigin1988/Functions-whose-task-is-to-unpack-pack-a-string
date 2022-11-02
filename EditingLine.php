<?php

function packingString(string $string) : string
{
    $binaryArr = [];

    // Проверяем корректная ли строка.
    $arrToStr = explode("=>", $string);
    $trimmed_array = array_map('trim', $arrToStr);

    // Как я понял из задания, не корректная строка это отсутствие значения, при существующем ключе.
    if ($trimmed_array[0] !== '""' && $trimmed_array[1] == '""' ) {
        return 'Некорректная строка';
    }

    if ($trimmed_array[0] !== '``' && $trimmed_array[1] == '``' ) {
        return 'Некорректная строка';
    }

    // Преобразую строку в массив.
    $stringToArr = str_split($string,1);
    foreach ($stringToArr as $value) {
        //Преобразую знак в десятичное число, согласно ASCII.
        $decimalASC = ord($value);
        //Преобразую десятичное число в двоичное.
        $binaryValue = decbin($decimalASC);
        //Добавляю ключ (&) к двоичному числу, что бы при распаковке я мог отделить числа.
        $binaryArr[] = $binaryValue . '00100110';
    }

    // Собираю массив в строку.
    return implode($binaryArr);
}

function unpackingString($binaryString) : string
{
    $decimalArray = [];
    $string = '';

    //Преобразую строку в массив, сеппаратор &.
    $arr = explode('00100110', $binaryString);
    array_pop($arr);

    //Получаю массив с десятичными значениями.
    foreach ($arr as $value) {
        $decimalArray[] = bindec($value);
    }

    //Преобразую в строку согласно ASCII
    foreach ($decimalArray as $value) {
        $string = $string . chr($value);
    }

    return $string;
}

//Для корректной работы нужен Nowdoc, внутри него не осуществляется никаких подстановок.
$packing = packingString(<<<'EOD'
"a4bc2d5e" => "aaaabccddddde"
EOD);

echo 'Строка в двоичном коде: ' . $packing . PHP_EOL;

$unStr = unpackingString($packing);

echo 'Распакованная строка: ' . $unStr . PHP_EOL;
