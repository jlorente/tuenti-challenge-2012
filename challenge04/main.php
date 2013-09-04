#!/usr/bin/php
<?php
/**
 * Tuenti challenge 2012
 * 
 * Challenge 04
 * 20 fast 20 furious
 * 
 * @author Jose Lorente Martin
 */
$stdin = fopen('php://stdin', 'r');
$testNumber = (int) trim(fgets($stdin));

for ($i = 0; $i < $testNumber; ++$i) {
    list($races, $karts, $groups) = explode(' ', trim(fgets($stdin)));
    $groups = explode(' ', trim(fgets($stdin)));
    
    $kartQueue = new KartQueue($groups);
    
    $remainingKarts = $karts;
    $firstId = $kartQueue->getCurrentId();
    $l = 0;
    while ($races > 0) {
        $remainingKarts -= $kartQueue->getCurrentValue();
        $kartQueue->dequeue();
        
        if ($kartQueue->getCurrentValue() > $remainingKarts || $kartQueue->getCurrentId() === $firstId) {
            --$races;
            $l += $karts - $remainingKarts;
            $remainingKarts = $karts;
            $firstId = $kartQueue->getCurrentId();
        }
    }
    
    echo $l.PHP_EOL;
}

class KartQueue
{
    /**
     * @var Node
     */
    protected $first;
   
    /**
     * @var Node
     */
    protected $last;
    
    public function __construct(array $groups)
    {
        $this->first = new Group(0, $groups[0]);
        $this->last = $this->first;
        $this->first->setNext($this->last);
        
        for ($i = 1, $t = count($groups); $i < $t; ++$i) {
            $this->enqueue(new Group($i, $groups[$i]));
        }
    }
    
    public function dequeue()
    {
        $return = $this->first;
        $this->first = $return->getNext();
        $this->last->setNext($return);
        $this->last = $return;
        
        return $return;
    }
    
    public function enqueue(Group $node)
    {
        $this->last->setNext($node);
        $this->last = $node;
    }
    
    public function getCurrentValue()
    {
        return $this->first->getValue();
    }
    
    public function getCurrentId()
    {
        return $this->first->getId();
    }
}

class Group
{
    /**
     * @var Node
     */
    protected $next;
    
    protected $id;
    
    protected $value;
    
    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }
    
    public function setNext(Group $next)
    {
        $this->next = $next;
    }
    
    public function getNext()
    {
        return $this->next;    
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getValue()
    {
        return $this->value;
    }
}