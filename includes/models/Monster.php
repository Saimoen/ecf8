<?php
class Monster
{
    private $arraySize;
    private $monsterArray = [];
    private $pv;
    private $force;
    private $x;
    private $y;

    public function __construct()
    {
        $this->arraySize = rand(10, 50);
        $this->retrieveMonsters();
        $this->pv;
        $this->force;
        $this->x;
        $this->y;
    }

    private function generateMonsters()
    {
        while (count($this->monsterArray) < $this->arraySize) {
            $this->x = rand(0, 20);
            $this->y = rand(0, 20);
            $this->pv = rand(30, 130);
            $this->force = rand(40, 120);
            $point = ["positionX" => $this->x, "positionY" => $this->y, "PV" => $this->pv, "Force" => $this->force];

            if (!$this->isDuplicate($point)) {
                $this->monsterArray[] = $point;
            }
        }
    }

    private function isDuplicate($point)
    {
        foreach ($this->monsterArray as $existingPoint) {
            if ($existingPoint === $point) {
                return true;
            }
        }
        return false;
    }
    private function retrieveMonsters()
    {
        if (isset($_SESSION['monsterArray'])) {
            $this->monsterArray = $_SESSION['monsterArray'];
        } else {
            $this->generateMonsters();
            $_SESSION['monsterArray'] = $this->monsterArray;
        }
    }
    public function getMonsters()
    {
        return $this->monsterArray;
    }

    public function getPV()
    {
        return  $this->pv;;
    }


}

// Usage
// You can change this to the desired array size


// Print the generated points