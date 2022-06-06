<?php

namespace App\DataFixtures;

use App\Entity\Lecturer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LecturerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=5; $i++) {
            $lecturer = new Lecturer;
            $lecturer->setName("Lecturer $i");
            $lecturer->setDateofbirth(\DateTime::createFromFormat('Y/m/d','1992/06/02'));
            $lecturer->setEmail("giangvien@greenwich.edu.vn");
            $lecturer->setAddress("Ha Noi");
            $lecturer->setImage("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSHHDoQB8bbzKASXXTfrg28WymLib_rw6249g&usqp=CAU");
            $manager->persist($lecturer);
        }

        $manager->flush();
    }
}
