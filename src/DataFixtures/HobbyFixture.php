<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "Yoga",
            "Cooking",
            "Pastry making",
            "Photography",
            "Blogging",
            "Reading",
            "Learning a language",
            "Lego building",
            "Drawing",
            "Coloring",
            "Painting",
            "Starting rug weaving",
            "Creating clothes or cosplay",
            "Making jewelry",
            "Metalworking",
            "Decorating pebbles",
            "Doing puzzles with more and more pieces",
            "Creating miniatures (houses, cars, trains, boats, etc.)",
            "Improving living space",
            "Learning to juggle",
            "Joining a book club",
            "Learning computer programming",
            "Learning more about survivalism",
            "Creating a YouTube channel",
            "Playing darts",
            "Learning to sing",
        ];

        for ($i = 0; $i<count($data);$i++) {
            $hobby = new Hobby();
            $hobby->setDesignation($data[$i]);
            $manager->persist($hobby);
        }

        $manager->flush();
    }
}
