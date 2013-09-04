#!/usr/bin/php
<?php
/**
 * Tuenti challenge 2012
 * 
 * Challenge 01
 * The cell phone keypad
 * 
 * @author Jose Lorente Martin
 */
$stdin = fopen('php://stdin', 'r');
$testNumber = (int) trim(fgets($stdin));

$cellPhone = new CellPhoneKeypad();
for ($i = 0; $i < $testNumber; ++$i) {
    $sentence = trim(fgets($stdin));
    
    echo $cellPhone->getTime($sentence).PHP_EOL;
}

class CellPhoneKeypad
{
    protected static $keypadUpper = array(	
                                        ' ' => array('x' => 0, 'y' => 0, 'p' => 1),
                                        '1' => array('x' => 0, 'y' => 0, 'p' => 2),
                                        'A' => array('x' => 0, 'y' => 1, 'p' => 1),
                                        'B' => array('x' => 0, 'y' => 1, 'p' => 2),
                                        'C' => array('x' => 0, 'y' => 1, 'p' => 3),
                                        '2' => array('x' => 0, 'y' => 1, 'p' => 4),
                                        'D' => array('x' => 0, 'y' => 2, 'p' => 1),
                                        'E' => array('x' => 0, 'y' => 2, 'p' => 2),
                                        'F' => array('x' => 0, 'y' => 2, 'p' => 3),
                                        '3' => array('x' => 0, 'y' => 2, 'p' => 4),
                                        'G' => array('x' => 1, 'y' => 0, 'p' => 1),
                                        'H' => array('x' => 1, 'y' => 0, 'p' => 2),
                                        'I' => array('x' => 1, 'y' => 0, 'p' => 3),
                                        '4' => array('x' => 1, 'y' => 0, 'p' => 4),
                                        'J' => array('x' => 1, 'y' => 1, 'p' => 1),
                                        'K' => array('x' => 1, 'y' => 1, 'p' => 2),
                                        'L' => array('x' => 1, 'y' => 1, 'p' => 3),
                                        '5' => array('x' => 1, 'y' => 1, 'p' => 4),
                                        'M' => array('x' => 1, 'y' => 2, 'p' => 1),
                                        'N' => array('x' => 1, 'y' => 2, 'p' => 2),
                                        'O' => array('x' => 1, 'y' => 2, 'p' => 3),
                                        '6' => array('x' => 1, 'y' => 2, 'p' => 4),
                                        'P' => array('x' => 2, 'y' => 0, 'p' => 1),
                                        'Q' => array('x' => 2, 'y' => 0, 'p' => 2),
                                        'R' => array('x' => 2, 'y' => 0, 'p' => 3),
                                        'S' => array('x' => 2, 'y' => 0, 'p' => 4),
                                        '7' => array('x' => 2, 'y' => 0, 'p' => 5),
                                        'T' => array('x' => 2, 'y' => 1, 'p' => 1),
                                        'U' => array('x' => 2, 'y' => 1, 'p' => 2),
                                        'V' => array('x' => 2, 'y' => 1, 'p' => 3),
                                        '8' => array('x' => 2, 'y' => 1, 'p' => 4),
                                        'W' => array('x' => 2, 'y' => 2, 'p' => 1),
                                        'X' => array('x' => 2, 'y' => 2, 'p' => 2),
                                        'Y' => array('x' => 2, 'y' => 2, 'p' => 3),
                                        'Z' => array('x' => 2, 'y' => 2, 'p' => 4),
                                        '9' => array('x' => 2, 'y' => 2, 'p' => 5),
                                        '0' => array('x' => 3, 'y' => 1, 'p' => 1),
                                        'caps' => array('x' => 3, 'y' => 2, 'p' => 1)
                                     );
                                     
    protected static $keypadLower = array(	
                                        ' ' => array('x' => 0, 'y' => 0, 'p' => 1),
                                        '1' => array('x' => 0, 'y' => 0, 'p' => 2),
                                        'a' => array('x' => 0, 'y' => 1, 'p' => 1),
                                        'b' => array('x' => 0, 'y' => 1, 'p' => 2),
                                        'c' => array('x' => 0, 'y' => 1, 'p' => 3),
                                        '2' => array('x' => 0, 'y' => 1, 'p' => 4),
                                        'd' => array('x' => 0, 'y' => 2, 'p' => 1),
                                        'e' => array('x' => 0, 'y' => 2, 'p' => 2),
                                        'f' => array('x' => 0, 'y' => 2, 'p' => 3),
                                        '3' => array('x' => 0, 'y' => 2, 'p' => 4),
                                        'g' => array('x' => 1, 'y' => 0, 'p' => 1),
                                        'h' => array('x' => 1, 'y' => 0, 'p' => 2),
                                        'i' => array('x' => 1, 'y' => 0, 'p' => 3),
                                        '4' => array('x' => 1, 'y' => 0, 'p' => 4),
                                        'j' => array('x' => 1, 'y' => 1, 'p' => 1),
                                        'k' => array('x' => 1, 'y' => 1, 'p' => 2),
                                        'l' => array('x' => 1, 'y' => 1, 'p' => 3),
                                        '5' => array('x' => 1, 'y' => 1, 'p' => 4),
                                        'm' => array('x' => 1, 'y' => 2, 'p' => 1),
                                        'n' => array('x' => 1, 'y' => 2, 'p' => 2),
                                        'o' => array('x' => 1, 'y' => 2, 'p' => 3),
                                        '6' => array('x' => 1, 'y' => 2, 'p' => 4),
                                        'p' => array('x' => 2, 'y' => 0, 'p' => 1),
                                        'q' => array('x' => 2, 'y' => 0, 'p' => 2),
                                        'r' => array('x' => 2, 'y' => 0, 'p' => 3),
                                        's' => array('x' => 2, 'y' => 0, 'p' => 4),
                                        '7' => array('x' => 2, 'y' => 0, 'p' => 5),
                                        't' => array('x' => 2, 'y' => 1, 'p' => 1),
                                        'u' => array('x' => 2, 'y' => 1, 'p' => 2),
                                        'v' => array('x' => 2, 'y' => 1, 'p' => 3),
                                        '8' => array('x' => 2, 'y' => 1, 'p' => 4),
                                        'w' => array('x' => 2, 'y' => 2, 'p' => 1),
                                        'x' => array('x' => 2, 'y' => 2, 'p' => 2),
                                        'y' => array('x' => 2, 'y' => 2, 'p' => 3),
                                        'z' => array('x' => 2, 'y' => 2, 'p' => 4),
                                        '9' => array('x' => 2, 'y' => 2, 'p' => 5),
                                        '0' => array('x' => 3, 'y' => 1, 'p' => 1),
                                        'caps' => array('x' => 3, 'y' => 2, 'p' => 1)
                                     );

    public function getTime($word)
    {
        $keypad = self::$keypadLower;
        $keypadCaps = self::$keypadUpper;
        
        $current = '0';
        $time = 0;
       
        $word = str_split($word);
        
        $lWord = count($word);
        
        $i = 0;
        while ($i < $lWord) {
            if (isset($keypad[$word[$i]])) {
                $moveX = abs($keypad[$word[$i]]['x'] - $keypad[$current]['x']);
                $moveY = abs($keypad[$word[$i]]['y'] - $keypad[$current]['y']);
                $current = $word[$i];
                ++$i;
            } else {
                $moveX = abs($keypad['caps']['x'] - $keypad[$current]['x']);
                $moveY = abs($keypad['caps']['y'] - $keypad[$current]['y']);
                $current = 'caps';
                
                $aux = $keypad;
                $keypad = $keypadCaps;
                $keypadCaps = $aux;
                
                unset($aux); 
            }
            
            if ($moveX !== 0 || $moveY !== 0) {
                while ($moveX !== 0 || $moveY !== 0) {
                    if ($moveX > 0 && $moveY > 0) {
                        --$moveX;
                        --$moveY;
                        $time += 350;
                    } elseif ($moveX > 0) {
                        --$moveX;
                        $time += 300;
                    } elseif ($moveY > 0) {
                        --$moveY;
                        $time += 200;
                    }
                }
            } else {
                $time += 500;
            }
            
            $time += $keypad[$current]['p'] * 100;
        }
        
        return $time;
    }
}