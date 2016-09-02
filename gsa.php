<?php
/**
 * code challenge for Neighborly
 *
 * Gale–Shapley variant
 *
 * by Jed Murdock
 * Sept 2, 2016
 *
 * to run:
 *
 * > php -f gsa.php
 *
 */


$buyerPrefs = [
  'a' => ['z', 'x', 'w', 'u', 'v', 's', 't', 'y', 'q' ,'r'],
  'b' => ['z', 'w', 'x', 't', 'y', 'u', 'v', 's', 'q' ,'r'],
  'c' => ['z', 'w', 'x', 'y', 'q' ,'r', 'u', 'v', 's', 't'],
  'd' => ['u', 'v', 's', 't', 'z', 'x', 'w', 'y', 'q', 'r'],
  'e' => ['v', 'z', 'x', 'w', 'u', 's', 't', 'y', 'q' ,'r']
];

$buyerNum = [
  'a' => 2,
  'b' => 1,
  'c' => 3,
  'd' => 2,
  'e' => 2
];

$sellerPrefs = [
  'z' => ['b','c','d','e','a'],
  'x' => ['b','a','c','d','e'],
  'y' => ['e','a','b','c','d'],
  'w' => ['e','a','b','c','d'],
  'v' => ['e','a','b','c','d'],
  'u' => ['b','c','d','e','a'],
  't' => ['b','a','c','d','e'],
  's' => ['d','e','a','b','c'],
  'r' => ['d','e','a','b','c'],
  'q' => ['c','d','e','a','b'],
];


$buyers   = ['a','b','c','d','e'];
$proposed = ['a'=>[],'b'=>[],'c'=>[],'d'=>[],'e'=>[]]; // buyer, any number
$engaged  = ['z'=>null,'x'=>null,'y'=>null,'w'=>null,'v'=>null,'u'=>null,'t'=>null,'s'=>null,'q'=>null,'r'=>null]; // seller, one buyer
$sold     = ['a'=>[],'b'=>[],'c'=>[],'d'=>[],'e'=>[]];


while ($buyer = array_shift($buyers)) {
  $seller = null;

  while (sizeof($sold[$buyer]) < $buyerNum[$buyer]) {

    foreach ($buyerPrefs[$buyer] as $potential){

        if (!in_array($potential, $proposed[$buyer]) ){
          $seller = $potential;

          if (empty($engaged[$seller]) && sizeof($sold[$buyer]) < $buyerNum[$buyer]) {
            echo "engaging {$seller} to {$buyer}\n";

            $sold[$buyer]     []= $seller;
            $engaged[$seller] = $buyer;
            $proposed[$buyer] []= $seller;

            break;
          }
          elseif (array_search($buyer, $sellerPrefs[$seller]) < array_search($engaged[$seller], $sellerPrefs[$seller])) {
            $jilt = $engaged[$seller];
            echo "{$jilt} jilted by {$seller} for {$buyer}\n";
            $engaged[$seller] = $buyer;
            $proposed[$buyer] []= $seller;

            $sold[$buyer] []= $seller;
            unset($sold[$jilt][ array_search($seller,$sold[$jilt]) ] );

            $buyers []= $jilt;
            break;
          }
        }

    } // foreach

  } // while

} // while

print "\nBuyers => Sellers\n";
print_r($sold);
print "\n";
