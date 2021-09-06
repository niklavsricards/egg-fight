<?php

/* *
- Vairākas olas ar dažādiem spēkiem  - check
- Randomā ģenerējas olas ar dažādiem spēkiem spēlētājam - check
- Olām ir daudzums (var būt vienādas olas ar lielāku daudzumu) - check
- Uzvaras gadījumā Tu saņem pretinieka olu. - check
- Zaudējuma gadījumā Tev pazūd ola - check
- Neizšķirta gadījumā abiem pazūd ola
- Kaujas simulācija beidzas tad, kad vienam no spēlētājiem beidzas olas - check
 * */

//possible solutioni - dupliceet olu masivu (divas puses katrai olai)
// - iedot olai quantity un zaudejuma gadijuma quantity -1 uz atdot pretiniekam

$eggCount = 5;

$eggs = [
    'Strong egg' => 70,
    'Medium egg' => 50,
    'Weak egg' => 30
];

function createEgg(string $name, int $power, int $quantity): stdClass {
    $egg = new stdClass();
    $egg->name = $name;
    $egg->power = $power;
    $egg->quantity = $quantity;

    return $egg;
}

$playerEggs = [];
for ($i = 0; $i < $eggCount; $i++) {
    $playerEgg = array_rand($eggs);
    $power = $eggs[$playerEgg];
    $playerEggs[] = createEgg($playerEgg, $power, 2);
}

$computerEggs = [];
for ($i = 0; $i < $eggCount; $i++) {
    $computerEgg = array_rand($eggs);
    $power = $eggs[$computerEgg];
    $computerEggs[] = createEgg($computerEgg, $power, 2);
}
//each egg has quantity 2 because it has two sides

$round = 1;
$game = true;

while ($game) {
    echo "*--------------------*" . PHP_EOL;
    echo "Round nr. $round" . PHP_EOL;

    $playerEgg = $playerEggs[array_rand($playerEggs)];
    echo "You are fighting with {$playerEgg->name}" . PHP_EOL;

    $computerEgg = $computerEggs[array_rand($computerEggs)];
    echo "Computer is fighting with {$computerEgg->name}" . PHP_EOL;

    $playerWinningChance = $playerEgg->power;
    $computerWinningChance = $computerEgg->power;
    $totalWinningChance = $computerWinningChance + $playerWinningChance;

    $fight = rand(1, $totalWinningChance);

    if ($fight > $playerWinningChance) {
        if ($playerEgg->quantity == 2) {
            $playerEgg->quantity -= 1;
            $eggLost = array_splice($playerEggs, array_search($playerEgg, $playerEggs), 1);
            $computerEggs = array_merge($computerEggs, $eggLost);
        } else {
            array_splice($playerEggs, array_search($playerEgg, $playerEggs), 1);
        }
        echo "Computer smashed your egg!" . PHP_EOL;
    } elseif ($fight < $playerWinningChance) {
        if ($computerEgg->quantity == 2) {
            $computerEgg->quantity -=1;
            $eggLost = array_splice($computerEggs, array_search($computerEgg, $computerEggs), 1);
            $playerEggs = array_merge($playerEggs, $eggLost);
        } else {
            array_splice($computerEggs, array_search($computerEgg, $computerEggs), 1);
        }
        echo "You smashed computer's egg!" . PHP_EOL;
    } else {
        if ($playerEgg->quantity == 2) {
            $playerEgg->quantity -= 1;
        } else {
            array_splice($playerEggs, array_search($playerEgg, $playerEggs), 1);
        }

        if ($computerEgg->quantity == 2) {
            $computerEgg->quantity -= 1;
        } else {
            array_splice($computerEggs, array_search($computerEgg, $computerEggs), 1);
        }

        echo "It is a draw! Both lost eggs!";
    }

    $playerEggCount = count($playerEggs);
    $computerEggCount = count($computerEggs);

    echo "You have {$playerEggCount} egg left" . PHP_EOL;
    echo "Computer has {$computerEggCount} egg left" . PHP_EOL;

    if ($playerEggCount == 0) {
        echo "Computer won!" . PHP_EOL;
        $game = false;
    } elseif ($computerEggCount == 0) {
        echo "Player won!" . PHP_EOL;
        $game = false;
    }

    $round++;
    sleep(2);
}