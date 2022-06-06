<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $course = new Course;
            $course->setName("Course $i");
            $course->setDescription("Description for course $i");
            $course->setDuration(rand(200,300));
            $manager->persist($course);
        }

        $manager->flush();
    }
}
