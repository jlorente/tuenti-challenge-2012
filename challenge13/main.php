#!/usr/bin/php
<?php
/**
 * Tuenti challenge 2012
 * 
 * Challenge 13
 * The crazy croupier
 * 
 * @author Jose Lorente Martin
 */
$stdin = fopen('php://stdin', 'r');
$testNumber = (int) trim(fgets($stdin));

for ($i = 1; $i <= $testNumber; ++$i) {
    list($nCards, $nCardsInSet) = explode(' ', trim(fgets($stdin)));
    
    $deckOMeter = new DeckOMeter($nCards, $nCardsInSet);
    echo "Case #$i: ".$deckOMeter->getMovements().PHP_EOL;
}

class DeckOMeter
{
    protected $nodeList;

    protected $nCards;
    
    protected $nCardsInSet;
    
    public function __construct($nCards, $nCardsInSet)
    {
        $this->nCards = $nCards;
        $this->nCardsInSet = $nCardsInSet;
    }
    
    public function getMovements()
    {
        $this->createGraphs();
        
        return $this->getCommonGraphsLength();
    }
    
    protected function getCommonGraphsLength()
    {
        $alreadyVisited = array();
        $graphs = array();
        for ($i = 1; $i <= $this->nCards; ++$i) {
            if (!isset($alreadyVisited[$i])) {
                $nextNode = $this->nodeList[$i];
                
                $graphLength = 0;
                while (!isset($alreadyVisited[$nextNode])) {
                    $alreadyVisited[$nextNode] = true;
                    $graphLength++;
                    $nextNode = $this->nodeList[$nextNode];
                }
                
                $graphs[] = $graphLength;
            }
        }

        $commonGraphLength = $graphs[0];
        for ($i = 1, $t = count($graphs); $i < $t; ++$i) {
            $commonGraphLength = self::leastCommonMultiple($commonGraphLength, $graphs[$i]);
        }
        
        return $commonGraphLength;
    }
    
    protected function createGraphs()
    {
        $pos = 1;
        $rightCounter = $this->nCards;
        $leftCounter = $this->nCardsInSet;
        
        $loops = $rightCounter / $leftCounter > 2 ? $leftCounter : $rightCounter - $leftCounter;
        while ($loops-- > 0) {
            $this->nodeList[$leftCounter--] = $pos++;   
            $this->nodeList[$rightCounter--] = $pos++;
        } 
        while ($leftCounter > 0) {
            $this->nodeList[$leftCounter--] = $pos++;
        }
        while ($rightCounter > $this->nCardsInSet) {
            $this->nodeList[$rightCounter--] = $pos++;
        }
    }
    
    protected function addNode($from, $to)
    {
        $from = (int) $from;
        $to = (int) $to;
        if (isset($this->nodeList[$from])) {
            $nodeFrom = $this->nodeList[$from];
        } else {
            $nodeFrom = new GraphNode($from);
            $this->nodeList[$from] = $nodeFrom;
        }
        if (isset($this->nodeList[$to])) {
            $nodeTo = $this->nodeList[$to];
        } else {
            $nodeTo = new GraphNode($to);
            $this->nodeList[$to] = $nodeTo;
        }
        
        $nodeFrom->setNext($nodeTo);
    }
    
    public static function greatestCommonDivisor($x, $y)
    {
        $mod = bcmod($x, $y);
        while ($mod != 0) { 
            $x = $y; 
            $y = $mod;
            $mod = bcmod($x, $y);
        } 
        return $y;
    }
    
    public static function leastCommonMultiple($x, $y)
    {
        return bcdiv(bcmul($x, $y), self::greatestCommonDivisor($x, $y));
    }
}

/*
//BRUTE FORCE METHOD FOR UNBELIEVERS

for ($i = 0; $i < $testNumber; ++$i) {
    list($nCards, $nCardsInSet) = explode(' ', trim(fgets($stdin)));
    
    $initialArray = array_keys(array_fill(0, $nCards, 1));
    $initalArrayString = implode('', $initialArray);
    
    $array = $initialArray;
    $count = 0;
    while (true) {
        $count++;
        $leftArray = array_slice($array, 0, $nCardsInSet);
        $rightArray = array_slice($array, $nCardsInSet);
        
        $array = array();
        while (!empty($leftArray) && !empty($rightArray)) {
            $array[] = array_pop($leftArray);
            $array[] = array_pop($rightArray);
        }
        
        $last = empty($leftArray) ? $rightArray : $leftArray;
        while (!empty($last)) {
            $array[] = array_pop($last);
        }
        
        $string = implode('', $array);
        if ($string == $initalArrayString){
            echo $count.PHP_EOL;
            break;
        }
    }
}*/