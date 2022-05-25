<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TodoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $todo = new Todo;
            $todo->setDescription("This is todo description");
            $todo->setName("Todo $i");
            $todo->setCategory("Work");
            $todo->setPriority(rand(1,5)); //1: Highest priority, 5: Lowest priority
            $todo->setDuedate(\DateTime::createFromFormat('Y-m-d','2022-05-25'));
            $manager->persist($todo);
        }

        $manager->flush();
    }
}
