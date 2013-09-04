#!/usr/bin/php
<?php
/**
 * Tuenti challenge 2012
 * 
 * Challenge 10
 * Coding m00re and m00re
 * 
 * @author Jose Lorente Martin
 */
$forthProgram = new ForthProgram();
$forthProgram->run();

class ForthProgram
{
    protected $forthStack;
    
    protected static $funcs = array(
    								'$'             => 'subtract',
                                    '@'             => 'add',
                                    '&'             => 'divide',
                                    '#'             => 'multiply',
                                    'mirror'        => 'mirror',
                                    'breadandfish'  => 'cloneValue',
                                    'fire'          => 'pop',
                                    'dance'         => 'swap',
                                    'conquer'       => 'clean',
                                    '.'             => 'popAndEcho'
                                );
                                
    public function __construct()
    {
        $this->forthStack = new SplStack();
    }
    
    public function run()
    {
        $stdin = fopen('php://stdin', 'r');
        while (($line = fgets($stdin)) !== false) {
            $line = trim($line);
            
            $forthOperands = explode(' ', $line);
            foreach ($forthOperands as $operand) {
                if (is_numeric($operand)) {
                    $this->forthStack->push($operand);
                } elseif (isset(self::$funcs[$operand])) {
                    call_user_method(self::$funcs[$operand], $this);   
                }
            } 
        }
    }
    
    protected function add()
    {
        $valueA = $this->forthStack->pop();
        $valueB = $this->forthStack->pop();
        
        $this->forthStack->push($valueB + $valueA);
    }
    
    protected function subtract()
    {
        $valueA = $this->forthStack->pop();
        $valueB = $this->forthStack->pop();
        
        $this->forthStack->push($valueB - $valueA);
    }
    
    public function multiply()
    {
        $valueA = $this->forthStack->pop();
        $valueB = $this->forthStack->pop();
        
        $this->forthStack->push($valueB * $valueA);
    }
    
    protected function divide()
    {
        $valueA = $this->forthStack->pop();
        $valueB = $this->forthStack->pop();
        
        $this->forthStack->push($valueB / $valueA);
    }
    
    protected function cloneValue()
    {
        $value = $this->forthStack->pop();
        
        $this->forthStack->push($value);
        $this->forthStack->push($value);
    }
    
    protected function mirror()
    {
        $value = $this->forthStack->pop();
        
        $this->forthStack->push(-$value);
    }

    protected function swap()
    {
        $valueA = $this->forthStack->pop();
        $valueB = $this->forthStack->pop();
        
        $this->forthStack->push($valueA);
        $this->forthStack->push($valueB);
    }
    
    protected function pop()
    {
        $this->forthStack->pop();
    }
    
    public function clean()
    {
        $this->forthStack = new SplStack();
    }
    
    public function popAndEcho()
    {
        if ($this->forthStack->isEmpty() !== true) {
            echo $this->forthStack->pop();
        } else {
            echo '0';
        }
        echo PHP_EOL;
        
    }
}