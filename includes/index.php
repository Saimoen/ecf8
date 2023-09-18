<?php
ob_start();
require_once plugin_dir_path(__FILE__) . '/controllers/controller.php';
require_once plugin_dir_path(__FILE__) . '/models/Player.php';
require_once plugin_dir_path(__FILE__) . '/models/Monster.php';
require_once plugin_dir_path(__FILE__) . '/models/Chest.php';
require_once plugin_dir_path(__FILE__) . '/db/connect.php';
$monster = new Monster();
$chest = new Chest();
$player = new Player('');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monster Game</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<style>
    .game-board {
        display: grid;
        grid-template-columns: repeat(20, 30px);
        grid-template-rows: repeat(20, 30px);
        gap: 1px;
    }
    .cell {
        width: 30px;
        height: 30px;
        border: 1px solid black;

        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .player {
        background-color: white;
        color: white;
    }
    .monster {
        background-color: white;
        color: white;
    }
    .chest {
        background-color: white;
        color: white;
    }
</style>
<div class="row mt-">
    <div class="col-3"></div>
    <div class="col-6"></div>
</div>
<div class="container text-center">
    <div class="header">
        <h1 class="text-primary" style="padding-top: 20px; text-align: center;">Find the Treasure</h1>
    </div>
    <hr class="border border-primary border-3 opacity-75">
    <div class="row">
        <div class="col-md-9">
            <div class="game-board">
                <?php $boardSize = 21;
                for ($row = 1; $row < $boardSize; $row++) {

                    for ($col = 1; $col < $boardSize; $col++) {
                        echo '<div class="cell';
                        if ($player->getPositionX() === $col && $player->getPositionY() === $row) {
                            echo ' player">🚹';
                        } elseif ($chest->getPositionX() === $col && $chest->getPositionY() === $row) {
                            echo ' chest">❓';
                        } else {
                            $isMonsterHere = false;
                            foreach ($monster->getMonsters() as $monsterData) {
                                if ($monsterData["positionX"] === $col && $monsterData["positionY"] === $row) {
                                    $isMonsterHere = true;
                                    break;
                                }
                            }
                            if ($isMonsterHere) {
                                echo ' monster">❓️';
                            } else {
                                echo ' "> ';
                            }
                        };
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>
        <div class="col-md-3" style="right: 90px;">
            <p>Déplacez-vous sur la carte :</p>
            <div class="w-100 mx-auto text-center">
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4">
                        <a href="<?php echo site_url(); ?>/controllers/controller.php?direction=0" target="_parent"><i class="fa-solid fa-arrow-up fa-3x"></i></a>
                    </div>
                    <div class="col-4"></div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <a href="<?php echo site_url(); ?>/controllers/controller.php?direction=3"><i class="fa-solid fa-arrow-left fa-3x"></i></a>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <a href="<?php echo site_url(); ?>/controllers/controller.php?direction=1"><i class="fa-solid fa-arrow-right fa-3x"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4">
                        <a href="<?php echo site_url(); ?>/controllers/controller.php?direction=2"><i class="fa-solid fa-arrow-down fa-3x"></i></a>
                    </div>
                    <div class="col-4"></div>
                </div>
                <div class="row"></div>
            </div>
            <p>Vos caractéristiques :</p>
            <div>
                <div class="col-md-12 text-center mt-4" id="carac">
                    <i class="fa-solid fa-heart fa-2x" style="color: red;">&nbsp;<?php echo $player->getPV() ?></i>
                    <br />
                    <br />
                    <i class="fa-solid fa-bolt fa-2x" style="color: orange;">&nbsp;<?php echo $player->getPower() ?></i>
                    <br />
                    <br />
                    <i class="fa-solid fa-2x" style="color: blue;">XP&nbsp;<?php echo $player->getXp() ?></i>
                </div>
            </div>
            <br>
            <div class="border border-rounded p-3" style="width: 100%;">
                <?php echo findChest() ?>
            </div>
            <div class="w-100 mx-auto text-center mt-3">
                <a class="btn btn-danger" href="<?php echo site_url(); ?>/controllers/controller.php?reset=true">Nouvelle Partie</a>
            </div>
        </div>
    </div>
</div>
<script>
    function movePlayer(direction) {
        // Get the player's current position
        var playerX = document.querySelector('.player').getAttribute('data-x');
        var playerY = document.querySelector('.player').getAttribute('data-y');

        // Move the player in the specified direction
        switch (direction) {
            case 0:
                playerY--;
                break;
            case 1:
                playerX++;
                break;
            case 2:
                playerY++;
                break;
            case 3:
                playerX--;
                break;
        }

        // Update the player's position
        document.querySelector('.player').setAttribute('data-x', playerX);
        document.querySelector('.player').setAttribute('data-y', playerY);

        // Update the player's position on the server
        // TODO: Implement a function to update the player's position on the server
        // updatePlayerPosition(playerX, playerY);
    }

    // Add click listeners to the arrow buttons
    document.querySelector('.arrow-up').addEventListener('click', function() {
        movePlayer(0);
    });

    document.querySelector('.arrow-right').addEventListener('click', function() {
        movePlayer(1);
    });

    document.querySelector('.arrow-down').addEventListener('click', function() {
        movePlayer(2);
    });

    document.querySelector('.arrow-left').addEventListener('click', function() {
        movePlayer(3);
    });

</script>
</body>
</html>