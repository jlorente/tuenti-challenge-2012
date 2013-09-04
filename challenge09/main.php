#!/usr/bin/php
<?php
/**
 * Tuenti challenge 2012
 * 
 * Challenge 09
 * Il nomme della magnolia
 * 
 * @author Jose Lorente Martin
 */
define('_PATH', realpath(dirname(__FILE__)).'/');
$stdin = fopen('php://stdin', 'r');
$testNumber = (int) trim(fgets($stdin));

$searchedWords = $ordered = array();
for ($i = 0; $i < $testNumber; ++$i) {
    list($word, $apperance) = explode(' ', trim(fgets($stdin)));
    
    $word = strtolower($word);
    $searchedWords[$word][$apperance] = '';
    $searchedWords[$word]['n'] = 0;
    
    $orderedWords[] = array($word, $apperance);
}

fclose($stdin);

$found = 0;
$foundWords = array();
$files = scandir(_PATH . 'documents/');
$f = 2; 
$nFiles = count($files);
while ($f <= $nFiles && $found < $testNumber) {
    $fResource = fopen(_PATH . 'documents/' . $files[$f], 'r');
    
    $lNumber = 0;
    while (($line = fgets($fResource)) !== false && $found < $testNumber) {
        $lNumber++;
        $line = trim($line);
        $words = explode(' ', $line);
        
        $wNumber = 0;
        $n = count($words);
        $i = 0;
        while ($i < $n && $found < $testNumber) {
            $wNumber++;
            $word = strtolower($words[$i]);
            if (isset($searchedWords[$word])) {
                $searchedWords[$word]['n']++;
                if (isset($searchedWords[$word][$searchedWords[$word]['n']])) {
                    $foundWords[$word][$searchedWords[$word]['n']] = (int) $files[$f].'-'.$lNumber.'-'.$wNumber;
                    $found++;
                }
            }
            ++$i;
        }
    }
    ++$f;
}

foreach ($orderedWords as $word) {
    echo $foundWords[$word[0]][$word[1]].PHP_EOL;
}