<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 *
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Course $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Course $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Course[]
     */
    public function sortByNameAscending()
    {
        return $this->createQueryBuilder('course')
            ->orderBy('course.name', "ASC")
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Course[]
     */
    public function sortByNameDescending()
    {
        return $this->createQueryBuilder('course')
            ->orderBy('course.name', "DESC")
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Course[]
    */
    public function searchByName($name)
    {
        return $this->createQueryBuilder('course')
            ->andWhere('course.name LIKE :name')
            ->setParameter('name', '%'. $name . '%')
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }
}

