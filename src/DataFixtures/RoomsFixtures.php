<?php

namespace App\DataFixtures;

use App\Entity\Rooms;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RoomsFixtures extends Fixture
{
    const DATA = [
        "Cuisine",
        "Salon",
        "Salle à manger",
        "Salle de bain",
        "Chambre 1",
        "Chambre 2",
        "Chambre 3",
        "Chambre 4",
        "Garage",
        "Cave",
        "Grenier",
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::DATA as $data)
        {
            $room = new Rooms();
            $room->setName($data);
            $manager->persist($room);
        }


        $manager->flush();
    }
}
