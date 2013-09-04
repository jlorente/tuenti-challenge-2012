#!/usr/bin/php
<?php
/**
 * Tuenti challenge 2012
 * 
 * Challenge 02
 * The binary granny
 * 
 * @author Jose Lorente Martin
 */
$stdin = fopen('php://stdin', 'r');
$testNumber = (int) trim(fgets($stdin));

for ($i = 1; $i <= $testNumber; ++$i) {
    $input = trim(fgets($stdin));
    
    echo "Case #$i: ".getNuts($input).PHP_EOL;
}

function getNuts($number)
{
    $b = base_convert($number, 10, 2);
    $c = strlen($b) - 1;
    $d = str_repeat('1', $c);   
    $n = base_convert($d, 2, 10);
    
    $rest = bcsub($number, $n);
    
    $e = base_convert($rest, 10, 2);
    $e = str_replace('0', '', $e);
    
    return strlen($e) + $c;
}