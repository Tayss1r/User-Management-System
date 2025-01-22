<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Person>
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    //    /**
    //     * @return Person[] Returns an array of Person objects
    //     */
        public function findByAge($min, $max): array
        {
            $qb = $this->createQueryBuilder('p');
            $this->addInterval($qb, $min, $max);
            return $qb->getQuery()->getScalarResult();
        }

        public function statsPersonByAgeInterval($min, $max): array
        {
            $qb = $this->createQueryBuilder('p')
            ->select('avg(p.age) as averageAge, count(p.id) as personCount');
            $this->addInterval($qb, $min, $max);
            return $qb->getQuery()->getResult();
        }


    //    public function findOneBySomeField($value): ?Person
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


        private function addInterval(QueryBuilder $qb ,$min, $max) {
            $qb->andWhere('p.age >= :min and p.age <= :max')
                ->setParameter('min', $min)
                ->setParameter('max', $max);
        }
}
