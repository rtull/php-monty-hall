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

//create prize set
$prizes = array($lose,$lose,$win);

$i = 0;
    
echo 'running ' . number_format($iterations) . " simulations of the Monty Hall problem\n\n";

while ($i < $iterations) {
    $i++;

    $doors = array();

    //randomize the prizes
    shuffle($prizes);

    $j = 1;

    //assign each prize to a door
    foreach ($prizes as $prize) {
        $name = 'door_' . $j;
        $doors[$name] = $prize;
        $j++;
    }

    //identify the winning door
    $win_door = array_search($win, $doors, 1);
    if ($echo) {
        echo "winning door is $win_door\n";
    }

    //randomly select a door
    $initial_choice = array_rand($doors);
    if ($echo) {
        echo "initial choice is $initial_choice\n";
    }

    //get rid of a losing door
    //equivalent to host "showing" the door
    $remaining_doors = $doors;
    unset($remaining_doors[$initial_choice]);

    $host_door = array_search($lose, $remaining_doors, 1);
    unset($doors[$host_door]);
    if ($echo) {
        echo 'the host opens ' . $host_door . "\n";
    }

    //randomly choose to swtich or stay
    if (rand()%2 == 1) {
        //player chooses to stay for first half of iterations
        $type = 'stay';
        $final_choice = $doors[$initial_choice];
        $win_status = checkWin($final_choice);
    } else {
        //player chooses to switch for second half of iterations
        $type = 'switch';
        unset($doors[$initial_choice]);
        $final_choice = reset($doors);
        $win_status = checkWin($final_choice);
    }

    $stats['tot']++;
    $stats[$type]['tot']++;
    if ($echo) {
        echo "player chooses to $type\n";
    }

    //count results of player's choice
    if ($win_status == true) {
        if ($echo) {
            echo "player wins\n\n";
        }
        $stats[$type]['wins']++;
    } elseif ($win_status == false) {
        if ($echo) {
            echo "player loses\n\n";
        }
        $stats[$type]['losses']++;
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

//determine whether player won
function checkWin($choice) {
    global $win;

    if ($choice == $win) {
        return true;
    } elseif ($choice != $win) {
        return false;
    }
}
