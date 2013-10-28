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
Graph::main();

class Graph
{
    protected $previousNext = array();
    
    protected $nextPrevious = array();
    
    protected $vertexes = array();
    
    public $queue;
    
    public function __construct()
    {
        $this->queue = new SplQueue();
    }
    
    public static function main()
    {
        $graph = new Graph();
        $graph->createFromStdin();
        $graph->resolve();
    }
    
    public function createFromStdin()
    {
        $stdin = fopen('php://stdin', 'r');

        while (($passWordChars = fgets($stdin)) !== false) {
            $passWordChars = str_split(trim($passWordChars));
            
            $this->vertexes[$passWordChars[0]] = $passWordChars[0];
            $prev = 0;
            for ($i = 1, $t = count($passWordChars); $i < $t; ++$i) {
                $this->previousNext[$passWordChars[$i - 1]][$passWordChars[$i]] = true;
                $this->nextPrevious[$passWordChars[$i]][$passWordChars[$i - 1]] = true;
                $this->vertexes[$passWordChars[$i]] = $passWordChars[$i];
            }
        }
    }
    
    public function resolve()
    {
        $orderBlocks = array();
        $this->queue = new SplQueue();
        foreach ($this->vertexes as $vertex) {
            if (!isset($this->nextPrevious[$vertex])) {
                $this->queue->enqueue($vertex);
                $block[] = $vertex;
            }
        }
        $orderBlocks[] = $block;
        
        while ($this->queue->isEmpty() !== true) {
            $vertexPivot = $this->queue->dequeue();

            if (isset($this->previousNext[$vertexPivot])) {
                $previousNext = $this->previousNext[$vertexPivot];
                $block = array();
                foreach ($previousNext as $next => $v) {
                    unset($this->previousNext[$vertexPivot][$next]);
                    unset($this->nextPrevious[$next][$vertexPivot]);
                    
                    if (count($this->nextPrevious[$next]) <= 0) {
                        $this->queue->enqueue($next);
                        $block[] = $next;
                    }
                }
                
                if (count($block) > 0) {
                    $orderBlocks[] = $block;
                }
            }
        }
        unset($block);
        
        $results = array();
        $results[0] = '';
        for ($i = 0, $l = count($orderBlocks); $i < $l; ++$i) {
            $perm = new Permutation($orderBlocks[$i]);
            $solutions = $perm->getSolutions();
            $aux = array();
            for ($j = 0, $m = count($solutions); $j < $m; ++$j) {
                for ($k = 0, $n = count($results); $k < $n; ++$k) {
                    $aux[] = $results[$k].implode($solutions[$j]);
                }
            }
            $results = $aux;
        }
        
        for ($i = 0, $l = count($results); $i < $l; ++$i) {
            $pivot = $i;
            $value = $results[$pivot];
            
            while ($pivot > 0 && $results[$pivot - 1] > $value) {
                $results[$pivot] = $results[$pivot - 1];
                $pivot--;
            }
            $results[$pivot] = $value;
        }
        
        for ($i = 0; $i < $l; ++$i) {
            echo $results[$i].PHP_EOL;
        }
    }
}

class Permutation
{
    protected $solutions;
    
    protected $elements;
    
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }
    
    protected function resolvePermutations(array $array, array $solution = array())
    {
        $l = count($array);
        if ($l <= 0) {
            $this->solutions[] = $solution;
        }
        
        foreach ($array as $key => $element) {
            $copyArray = $array;
            $copySolution = $solution;
            
            $copySolution[] = $element;
            unset($copyArray[$key]);
            
            $this->resolvePermutations($copyArray, $copySolution);
        }
    }
    
    public function getSolutions()
    {
        if ($this->solutions === null) {
            $this->solutions = array();
            $this->resolvePermutations($this->elements);
        }
        
        return $this->solutions;
    }
}