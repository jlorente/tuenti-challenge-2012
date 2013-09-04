#!/usr/bin/php
<?php
/**
 * Tuenti challenge 2012
 * 
 * Challenge 03
 * The evil trader
 * 
 * @author Jose Lorente Martin
 */
$stdin = fopen('php://stdin', 'r');

$i = 1;
$pivot = 0;
$sellPivot = 0;
$pivotPrice = (int) trim(fgets($stdin));
$currentMax = 0;
while (($line = fgets($stdin)) !== false) {
    $stockPrice = (int) trim($line);
    
    if ($stockPrice < $pivotPrice) {
        $pivotPrice = $stockPrice;
        $pivot = $i;
    } else { 
        $diff = $stockPrice - $pivotPrice;
        if ($diff > $currentMax) {
            $currentMax = $diff;
            $buyPivot = $pivot;
            $sellPivot = $i;
        }
    }
    ++$i;
}

echo ($buyPivot * 100).' '.($sellPivot * 100).' '.$currentMax.PHP_EOL;