#!/usr/bin/php
<?php
/**
 * Tuenti challenge 2012
 * 
 * Challenge 07
 * The "secure" password
 * 
 * NOT COMPLETED - GIVES ONLY ONE VALID OPTION
 * 
 * @author Jose Lorente Martin
 */
$stdin = fopen('php://stdin', 'r');

$nodeList = array();
while (($passWordChars = fgets($stdin)) !== false) {
    $passWordChars = str_split(trim($passWordChars));
    
    $beforeList = array();
    if (isset($nodeList[$passWordChars[0]])) {
        $beforeList[0] = $nodeList[$passWordChars[0]];
    } else {
        $beforeList[0] = new Node($passWordChars[0]);
        $nodeList[$passWordChars[0]] = $beforeList[0];
    }
    
    for ($i = 1, $t = count($passWordChars); $i < $t; ++$i) {
        if (isset($nodeList[$passWordChars[$i]])) {
            $node = $nodeList[$passWordChars[$i]];
        } else {
            $node = new Node($passWordChars[$i]);
            $nodeList[$passWordChars[$i]] = $node;
        }
        
        foreach ($beforeList as $before) {
            $before->before($node);
            $node->after($before);
        }
        $beforeList[] = $node;
    }
}

$values = array_values($nodeList);
$options = false;
for ($i = 0, $t = count($values); $i < $t; ++$i) {
    $pivot = $i;
    $value = $values[$i];
    while ($pivot > 0 && ($check = Node::goesAfter($values[$pivot - 1], $value)) >= 0) {
        if ($check == 0) {
            $options = true;
        }
        $values[$pivot] = $values[$pivot - 1];
        $pivot--;
    }
    $values[$pivot] = $value;
}

Node::printNodes($values);


class Node
{
    protected $before = array();
    
    protected $after = array();
    
    protected $value;
     
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function before(Node $before, $deep = true)
    {
        $this->before[$before->getValue()] = $before;

        if ($deep === true) {
            $before->after($this, false);
            foreach ($before->getBeforeList() as $beforeDeep) {
                $this->before($beforeDeep);
            }
        }
    }

    public function after(Node $after, $deep = true)
    {
        $this->after[$after->getValue()] = $after;

        if ($deep === true) {
            $after->before($this, false);
            foreach ($after->getAfterList() as $afterDeep) {
                $this->after($afterDeep);
            }
        }
    }
    
    public function getBeforeList()
    {
        return $this->before;
    }
    
    public function getAfterList()
    {
        return $this->after;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public static function goesAfter(Node $a, Node $b)
    {
        $aAfterList = $a->getAfterList();
        $aBeforeList = $a->getBeforeList();
        if (isset($aAfterList[$b->getValue()])) {
            return 1;
        } elseif (!isset($aAfterList[$b->getValue()]) && !isset($aBeforeList[$b->getValue()])) {
            return 0;
        } else {
            return -1;
        }
    }
    
    public static function printNodes(array $nodes)
    {
        foreach ($nodes as $node) {
            echo $node->getValue();
        }
        echo PHP_EOL;
    }
}