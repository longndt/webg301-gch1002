<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //sử dụng vòng lặp for để add được nhiều object (record) cùng lúc
        for ($i=1; $i<=20 ; $i++) {
            //tạo variable đại diện cho 1 object Article
            $article = new Article;
            //sử dụng setter để set dữ liệu cho object
            $article->setLength(rand(5,30));  //random 1 số trong khoảng 5 đến 30
            $article->setName("Article " . $i);
            $article->setDate(\DateTime::createFromFormat('Y-m-d','2022-05-11'));
            $article->setImage("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT2p9aDPHxa5Mw9_2ICGpeG9fYpSqywo8tkBA&usqp=CAU");
            //lưu dữ liệu vào DB
            $manager->persist($article);
        }

        //confirm thao tác add dữ liệu vào DB
        $manager->flush();
    }
}
