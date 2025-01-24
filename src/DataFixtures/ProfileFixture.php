<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $profile = new \App\Entity\Profile();
        $profile->setRs('twitter');
        $profile->setUrl('https://twitter.com/tayssirferhi');

        $profile1 = new \App\Entity\Profile();
        $profile1->setRs('Facebook');
        $profile1->setUrl('https://www.facebook.com/tayssir.ferhi');

        $profile2 = new \App\Entity\Profile();
        $profile2->setRs('LinkedIn');
        $profile2->setUrl('https://www.linkedin.com/in/tayssir-ferhi-1138a0247');

        $profile3 = new \App\Entity\Profile();
        $profile3->setRs('Github');
        $profile3->setUrl('https://github.com/Tayss1r');

        $manager->persist($profile);
        $manager->persist($profile1);
        $manager->persist($profile2);
        $manager->persist($profile3);

        $manager->flush();
    }
}
