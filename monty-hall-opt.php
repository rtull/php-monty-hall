<?php

// set initial values
$iterations = 10000000;
$echo = false;

$lose = 'goat';
$win = 'car';

$stats = array();

$stats['tot'] = 0;

$stats['stay']['tot'] = 0;
$stats['stay']['wins'] = 0;
$stats['stay']['losses'] = 0;

$stats['switch']['tot'] = 0;
$stats['switch']['wins'] = 0;
$stats['switch']['losses'] = 0;

$i = 0;
    
echo 'running ' . number_format($iterations) . " simulations of the Monty Hall problem\n\n";

while ($i < $iterations) {
    $i++;

    //create new prize set
    $prizes = array($lose,$lose,$win);

    $initial_choice = rand()%3;

    //randomly choose to switch or stay
    if (rand()%2 == 1) {
        //player chooses to stay for first half of iterations
        $type = 'stay';

        if ($prizes[$initial_choice] == $win) {
            $win_status = true;
        } else {
            $win_status = false;
        }
    } else {
        //player chooses to switch for second half of iterations
        $type = 'switch';

        if ($prizes[$initial_choice] == $win) {
            $win_status = false;
        } else {
            $win_status = true;
        }
    }

    $stats['tot']++;
    $stats[$type]['tot']++;

    //count results of player's choice
    if ($win_status == true) {
        $stats[$type]['wins']++;
    }
}

//calculate and display final results
$str = '';

$str .= '<ul>';
$str .= '<li>player chooses to stay ' . number_format($stats['stay']['tot']) . ' times</li>';
$winRateStaying = round($stats['stay']['wins'] / $stats['stay']['tot'],4)*100;
$stayWinTotal = round($stats['stay']['wins'] / $stats['tot'],4)*100;
$str .= '<li>win rate when staying is ' . $winRateStaying . '%</li>';
$str .= '<li>staying wins a total of ' . $stayWinTotal . '% of the time</li>';
$str .= '</ul>';

$str .= '<ul>';
$str .= '<li>player chooses to switch ' . number_format($stats['switch']['tot']) . ' times</li>';
$winRateSwitching = round($stats['switch']['wins'] / $stats['switch']['tot'],4)*100;
$switchWinTotal = round($stats['switch']['wins'] / $stats['tot'],4)*100;
$str .= '<li>win rate when switching is ' . $winRateSwitching . '%</li>';
$str .= '<li>switching wins a total of ' . $switchWinTotal . '% of the time</li>';
$str .= '</ul>';

echo $str;
