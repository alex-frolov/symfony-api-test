<?php

namespace App\Repository;

use App\Entity\BookLocale;
use App\Entity\Locales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookLocale|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookLocale|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookLocale[]    findAll()
 * @method BookLocale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookLocaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookLocale::class);
    }

    public function findByNameAndLocale(string $name, string $locale)
    {
        return $this->createQueryBuilder('bl')
            ->innerJoin('bl.book', 'b')
            ->andWhere('bl.name LIKE :name')
            ->andWhere('bl.locale = :locale')
            ->setParameter('name', '%' . $name . '%')
            ->setParameter('locale', $locale)
            ->setMaxResults(10000)
            ->getQuery()
            ->getResult();
    }

    public function persist(BookLocale $bookLocale): void
    {
        $this->_em->persist($bookLocale);
    }

    public function flush(): void
    {
        $this->_em->flush();
    }

    public function save(BookLocale $bookLocale): void
    {
        $this->_em->persist($bookLocale);
        $this->_em->flush();
    }

    // /**
    //  * @return BookLocale[] Returns an array of BookLocale objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookLocale
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
