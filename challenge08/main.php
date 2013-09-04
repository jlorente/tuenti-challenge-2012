#!/usr/bin/php
<?php
/**
 * Tuenti challenge 2012
 * 
 * Challenge 08
 * The demented cloning machine
 * 
 * @author Jose Lorente Martin
 */
$stdin = fopen('php://stdin', 'r');

$stringQueue = trim(fgets($stdin));
$arrayQueue = str_split($stringQueue);

$queue = new SplQueue();
foreach ($arrayQueue as $person) {
    $queue->enqueue($person);
}

$aux = new SplQueue();
while (($transformations = fgets($stdin)) !== false) {
    $transArray = explode(',', trim($transformations));
    $serie = array();
    foreach ($transArray as $transformation) {
        list($from, $to) = explode('=>', $transformation);
        $serie[$from] = $to;
    }
    
    while ($queue->isEmpty() !== true) {
        $current = $queue->dequeue();
        if (isset($serie[$current])) {
            for ($i = 0, $l = strlen($serie[$current]); $i < $l; ++$i) {
                $aux->enqueue($serie[$current]{$i});
            }
        } else {
            $aux->enqueue($current);
        }
    }
    
    $queue = $aux;
    $aux = new SplQueue();
}

$md5 = hash_init('md5');
while ($queue->isEmpty() !== true) {
    hash_update($md5, $queue->dequeue());
}
echo hash_final($md5).PHP_EOL;