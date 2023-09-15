<?php
require_once 'Player.php';


class Chest
{

    private $positionY;
    private $positionX;

    public function __construct()
    {
        // Initialize chest's position based on session or other logic
        if (isset($_SESSION['chestPositionX']) && isset($_SESSION['chestPositionY'])) {
            $this->positionX = $_SESSION['chestPositionX'];
            $this->positionY = $_SESSION['chestPositionY'];
        } else {
            // Set initial position
            $this->positionX = rand(1, 20);
            $this->positionY = rand(1, 20);
            $_SESSION['chestPositionX'] = $this->positionX;
            $_SESSION['chestPositionY'] = $this->positionY;
        }
    }

    function getPositionX()
    {
        return $this->positionX;
    }
    function getPositionY()
    {
        return $this->positionY;
    }
}
