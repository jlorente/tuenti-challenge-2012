#!/usr/bin/php
<?php
/**
 * Tuenti challenge 2012
 * 
 * Challenge 11
 * Descrambler
 * 
 * @author Jose Lorente Martin
 */
$wordSearcher = new WordSearcher();

$stdin = fopen('php://stdin', 'r');
$testNumber = (int) trim(fgets($stdin));
for ($i = 0; $i < $testNumber; ++$i) {
    list($rack, $word) = explode(' ', trim(fgets($stdin)));
    
    $computedChars = array();
    $rackChar = str_split($rack);
    $wordChar = str_split($word);
    for ($j = 0, $t = count($wordChar); $j < $t; ++$j) {
        if (!isset($computedChars[$wordChar[$j]])) {
            $rackCopy = $rackChar;
            $rackCopy[] = $wordChar[$j];
            
            $wordSearcher->searchWords($rackCopy);
            
            $computedChars[$wordChar[$j]] = true;
        }
    }
    
    echo $wordSearcher->getMaxScoreWord().' '.$wordSearcher->getMaxScore().PHP_EOL;
}

class WordSearcher
{
    protected $maxScore;
    
    protected $maxScoreWord;
    
    protected $dictionary;
    
    public function __construct()
    {
        $score = array(
                    'A'	=> 1,
                    'E' => 1,
                    'I' => 1,
                    'L' => 1,
                    'N' => 1,
                    'O' => 1,
                    'R' => 1,
                    'S' => 1,
                    'T' => 1,
                    'U' => 1,
                    
                    'D' => 2,
                    'G' => 2,
                    
                    'B' => 3,
                    'C' => 3,
                    'M' => 3,
                    'P' => 3,
        
                    'F' => 4,
                    'H' => 4,
                    'V' => 4,
                    'W' => 4,
                    'Y' => 4,
                    
                    'K' => 5,
                    
                    'J' => 8,
                    'X' => 8,
                    
                    'Q' => 10,
                    'Z' => 10
                 );
                 
        $file = fopen(realpath(dirname(__FILE__)).'/descrambler_wordlist.txt', 'r');
        while (($word = fgets($file)) !== false) {
            $word = trim($word);
            $splWord = str_split($word);
            $points = 0;
            foreach ($splWord as $char) {
                $points += $score[$char];
            }
            $this->dictionary[$word] = $points;
        }
        fclose($file);
        
        $this->maxPoints = 0;    
    }
    
    public function searchWords($lettersLeft, $word = '')
    {
        if (isset($this->dictionary[$word]) 
        && ($this->dictionary[$word] > $this->maxScore
            || ($this->dictionary[$word] == $this->maxScore && $word < $this->maxScoreWord))
        ) {
            $this->maxScoreWord = $word;
            $this->maxScore = $this->dictionary[$word];
        }
        
        if (count($lettersLeft) <= 0) {
            return;
        } else {
            foreach ($lettersLeft as $key => $letter) {
                $lettersLeftCopy = $lettersLeft;
                unset($lettersLeftCopy[$key]);
                $wordCopy = $word;
                $wordCopy .= $letter;
                
                $this->searchWords($lettersLeftCopy, $wordCopy);
            }
        }
    }
    
    public function getMaxScoreWord()
    {
        return $this->maxScoreWord;    
    }
    
    public function getMaxScore()
    {
        return $this->maxScore;
    }
}