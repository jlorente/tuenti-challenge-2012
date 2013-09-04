#!/usr/bin/php
<?php
/**
 * Tuenti challenge 2012
 * 
 * Challenge 06
 * Cross-stitched fonts
 * 
 * @author Jose Lorente Martin
 */
$stdin = fopen('php://stdin', 'r');
$testNumber = (int) trim(fgets($stdin));

for ($j = 0; $j < $testNumber; ++$j) {
    list($width, $height, $count) = explode(' ', trim(fgets($stdin)));
    
    $strSentence = trim(fgets($stdin));
    $sentence = explode(' ', $strSentence);
    $characters = strlen(str_replace(' ', '', $strSentence));
    $widthInPixels = $width * $count;
    $heightInPixels = $height * $count;
    
    $fontSize = floor($widthInPixels / strlen($strSentence));
    
    $currentFontSize = 0;
    $maxWordLength = 0;
    while (true) {
        $nLines = 1;
        $space = $maxSentenceLength = 0;
        for ($i = 0, $t = count($sentence); $i < $t; ++$i) {
            $wordLength = strlen($sentence[$i]);
            $wordSpace = $fontSize * $wordLength;
            $relativeSpace = $space + $wordSpace + ($i !== 0 ? $fontSize : 0);
            if ($relativeSpace > $widthInPixels) {
                $nLines++;
                $space = $wordSpace;
            } else {
                $space = $relativeSpace;
            }
            
            if ($space > $maxSentenceLength) {
                $maxSentenceLength = $space;
            }
            if ($wordLength > $maxWordLength) {
                $maxWordLength = $wordLength;
            }
        }

        if ($fontSize * $nLines > $heightInPixels || $fontSize * $maxWordLength > $widthInPixels) {
            break;
        } else {
            $currentFontSize = $fontSize;
            $fontSize++;
        }
    }

    $fabricInches = ceil($characters * (pow($currentFontSize, 2) / (2 * $count)));
    echo "Case #$j: ".$fabricInches.PHP_EOL;
}