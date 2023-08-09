<?php

namespace App\Repository;

use App\Entity\Affaire;
use App\Entity\Section;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Affaire>
 *
 * @method Affaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Affaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Affaire[]    findAll()
 * @method Affaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affaire::class);
    }

    public function save(Affaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Affaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

/**
 * @Route("/show/{id}", name="affaire_show", methods={"GET"})
 */
public function show(AffaireRepository $affaireRepository, $id)
{
    $affaire = $affaireRepository->find($id);

    if (!$affaire) {
        throw $this->createNotFoundException(
            'Aucune affaire trouvée pour cet id : '.$id
        );
    }

    return $this->render('admin_article/show.html.twig', ['affaire' => $affaire]);
}


   /**
    * @return Affaire[] Returns an array of Affaire objects
    */
    public function findBySearch($search)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.title LIKE :val')
            ->setParameter('val', '%' . $search . '%')
            ->getQuery()
            ->getResult();
    }
    
   








 

//    /**
//     * @return Affaire[] Returns an array of Affaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Affaire
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
