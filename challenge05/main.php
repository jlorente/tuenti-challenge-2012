#!/usr/bin/php
<?php
/**
 * Tuenti challenge 2012
 * 
 * Challenge 05
 * Time is never time again
 * 
 * @author Jose Lorente Martin
 */
$stdin = fopen('php://stdin', 'r');

$clockComparer = new ClockComparer();
$clockComparer->getTimestampStore();

while (($clocks = fgets($stdin)) !== false) {
    $clocks = trim($clocks);

    list($start, $to) = explode(' - ', $clocks);
    
    $start = new DateTime($start);
    $to = new DateTime($to);

    echo $clockComparer->getEnergyDifference($start, $to).PHP_EOL;
}

class ClockComparer
{
    protected $timestampStore;
    
    protected static $oldDelta = array(
                                        '0' => 6,
                                        '1'	=> 2,
                                        '2' => 5,
                                        '3' => 5,
                                        '4' => 4,
                                        '5' => 5,
                                        '6' => 6,
                                        '7' => 3,
                                        '8' => 7,
                                        '9' => 6
                                    );

    protected static $newDelta = array(
                                        '0' => array(
                                                    '1'	=> 0
                                               ),
                                        '1' => array(
                                                    '2' => 4
                                               ),
                                        '2' => array(
                                                    '0' => 2,
                                                    '3' => 1
                                               ),
                                        '3' => array(
                                                    '0' => 2,
                                                    '4' => 1
                                               ),
                                        '4' => array(
                                                    '5' => 2
                                               ),
                                        '5' => array(
                                                    '0' => 2,
                                                    '6' => 1
                                               ),
                                        '6' => array(
                                                    '7' => 1
                                               ),
                                        '7' => array(
                                                    '8' => 4
                                               ),
                                        '8' => array(
                                                    '9' => 0
                                               ),
                                        '9' => array(
                                                    '0' => 1
                                               ),
                                    );
                                    
    public function __construct()
    {
        $this->storeVariations();
    }
    
    public function storeVariations()
    {
        $secondUnits = $secondTens = '0';
        $minuteUnits = $minuteTens = '0';
        $hourUnits = $hourTens = '0';
        
        $energyDifference = 0;
        $this->timestampStore['000000'] = 0;
        for ($i = 0; $i < 86400; ++$i) {
            $changeEnergy = 0;
            if ($secondUnits < 9) {
                $changeEnergy += self::$newDelta[$secondUnits][$secondUnits + 1];
                $secondUnits++;
            } else {
                $changeEnergy += self::$newDelta[$secondUnits][0];
                $secondUnits = 0;
                 
                if ($secondTens < 5) {
                    $changeEnergy += self::$newDelta[$secondTens][$secondTens + 1];
                    $secondTens++;
                } else {
                    $changeEnergy += self::$newDelta[$secondTens][0];
                    $secondTens = 0;
                    
                    if ($minuteUnits < 9) {
                        $changeEnergy += self::$newDelta[$minuteUnits][$minuteUnits + 1];
                        $minuteUnits++;
                    } else {
                        $changeEnergy += self::$newDelta[$minuteUnits][0];
                        $minuteUnits = 0;
                         
                        if ($minuteTens < 5) {
                            $changeEnergy += self::$newDelta[$minuteTens][$minuteTens + 1];
                            $minuteTens++;
                        } else {
                            $changeEnergy += self::$newDelta[$minuteTens][0];
                            $minuteTens = 0;
                            
                            if ($hourTens < 2) {
                                if ($hourUnits < 9) {
                                    $changeEnergy += self::$newDelta[$hourUnits][$hourUnits + 1];
                                    $hourUnits++;
                                } else {
                                    $changeEnergy += self::$newDelta[$hourUnits][0];
                                    $hourUnits = 0;
                                     
                                    $changeEnergy += self::$newDelta[$hourTens][$hourTens + 1];
                                    $hourTens++;
                                }
                            } else {
                                if ($hourUnits < 3) {
                                    $changeEnergy += self::$newDelta[$hourUnits][$hourUnits + 1];
                                    $hourUnits++;
                                } else {
                                    $changeEnergy += self::$newDelta[$hourUnits][0];
                                    $changeEnergy += self::$newDelta[$hourTens][0];
                                    $hourUnits = 0;
                                    $hourTens = 0;
                                }
                            }
                        }
                    }
                }
            }

            $energyDifference += (self::$oldDelta[$hourTens] + self::$oldDelta[$hourUnits]
                                    + self::$oldDelta[$minuteTens] + self::$oldDelta[$minuteUnits]
                                    + self::$oldDelta[$secondTens] + self::$oldDelta[$secondUnits]) - $changeEnergy;
             
            $stamp = $hourTens.$hourUnits.$minuteTens.$minuteUnits.$secondTens.$secondUnits;
            if ($stamp !== '000000') {
                $this->timestampStore[$stamp] = $energyDifference;
            } else {
                $this->timestampStore['DAY'] = $energyDifference;
            }
        }
    }

    public function getEnergyDifference(Datetime $start, Datetime $to)
    {
        $interval = $to->diff($start, true);
        
        if ($start->format('Ymd') !== $to->format('Ymd')) {
            $energyDifference = $this->timestampStore['DAY'] - $this->timestampStore[$start->format('His')];  
            if ($interval->days > 0) {
                $energyDifference += ($interval->days - 1) * $this->timestampStore['DAY'];
            }
            
            $energyDifference += $this->timestampStore[$to->format('His')];
        } else {
            $energyDifference = $this->timestampStore[$to->format('His')] - $this->timestampStore[$start->format('His')];
        }
        
        return $energyDifference;
    }

    public function getTimestampStore()
    {
        return $this->timestampStore;
    }
}