<?php
require_once "Player.php";
require_once plugin_dir_path(__FILE__) . '../db/connect.php';
class Fight
{

    public function __construct()
    {
    }
    public function startFight($player, $monster)
    {
        global $conn;

        $fightResults = array();

        // Store monster's attributes in $fightResults
        $fightResults['monster'] = array(
            'pv' => $monster['PV'],
            'force' => $monster['Force']
        );
        $playerPv = $player->getPv();
        $monsterPower = $fightResults['monster']['force'];


        while ($player->getPV() > 0 && $fightResults['monster']['pv'] > 0) {
            // Player attacks

            $fightResults['monster']['pv'] -= $player->getPower();

            // Check if monster is defeated
            if ($fightResults['monster']['pv'] <= 0) {
                $player->setPv($playerPv);



                // Remove the monster from the monsters array
                $monsters = $_SESSION['monsterArray'];
                $indexToRemove = array_search($monster, $monsters);
                if ($indexToRemove !== false) {
                    unset($monsters[$indexToRemove]);
                }

                $_SESSION['monsterArray'] = $monsters;
                // Player regains all HP
                $player->setPV($player->getPV($playerPv));
                // Increase player's XP
                $player->setXp($player->getXp() + $monsterPower);
            } else {

                // Monster attacks if it's not defeated
                $player->setPV($player->getPV() - $fightResults['monster']['force']); // Player loses HP equal to monster's force
            }

            if ($player->getPV() <= 0) {
                $player->setPv(0);
                echo "you lose";
                $playerXp = $player->getXp();
                echo "nom d'utilisateur: " . $player->getUser();
                // header('Location:' '/findthetreaser');
                $user = $player->getUser();
                $sql = "INSERT INTO score  (username, score) VALUES ('$user',0)";
                mysqli_query($conn, $sql);
//                header("Location: /views/win.php");
                // die();
            }
        }
    }
}
