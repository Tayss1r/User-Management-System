<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "Data scientist",
            "Statistician",
            "Cybersecurity analyst",
            "ENT doctor (Otorhinolaryngologist)",
            "Sonographer",
            "Mathematician",
            "Software engineer",
            "Computer analyst",
            "Speech/Language pathologist",
            "Actuary",
            "Occupational therapist",
            "Human Resources Director",
            "Dental hygienist"
        ];
        for ($i = 0; $i<count($data);$i++) {
            $job = new Job();
            $job->setDesignation($data[$i]);
            $manager->persist($job);
        }


        $manager->flush();
    }
}
