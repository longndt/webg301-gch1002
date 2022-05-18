<?php

namespace App\DataFixtures;

use App\Entity\Mobile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
 

class MobileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $mobile = new Mobile;
            $mobile->setName('iPhone 13 Pro Max');
            $mobile->setPrice((float)(rand(1200,1300)));
            $mobile->setColor("Blue");
            $mobile->setQuantity(rand(20,50));
            $mobile->setDate(\DateTime::createFromFormat('Y-m-d','2022-03-06'));
            $manager->persist($mobile);
        }
        $manager->flush();
    }
}
