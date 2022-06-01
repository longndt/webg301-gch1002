<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Product $entity, bool $flush = true): void
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
    public function remove(Product $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
      * @return Product[] Returns an array of Product objects
    */
    public function sortByIdAsc()    //findAll()
    {
        return $this->createQueryBuilder('p')
                    ->orderBy('p.id', 'ASC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
     * @return Product[]
     */
    public function sortByIdDesc() 
    {
        return $this->createQueryBuilder('product')
                    ->orderBy('product.id','DESC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
      * @return Product[]  
    */
    public function sortByPriceAsc()    
    {
        return $this->createQueryBuilder('p')
                    ->orderBy('p.price', 'ASC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
     * @return Product[]
     */
    public function sortByPriceDesc() 
    {
        return $this->createQueryBuilder('product')
                    ->orderBy('product.price','DESC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
     * @return Product[]
     */
    public function searchByName($keyword)  //relative search
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name LIKE :value')
            ->setParameter('value', '%' . $keyword . '%')
            ->orderBy('p.name', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }
}
