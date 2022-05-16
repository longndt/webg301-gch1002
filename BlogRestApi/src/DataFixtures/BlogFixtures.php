<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=20; $i++) {
            $blog = new Blog;
            $blog->setAuthor("David Beckham");
            $blog->setTitle("Blog $i");
            $blog->setContent("David Beckham is one of the most famous football player in the world");
            $blog->setDate(\DateTime::createFromFormat('Y-m-d','2022-05-16'));
            $manager->persist($blog);
        }

        $manager->flush();
    }
}
