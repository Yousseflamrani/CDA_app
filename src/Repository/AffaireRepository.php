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
public function filterAffaires(
    ?User $user = null,
    ?Section $section = null,
    ?string $compte_c6 = null, 
    ?string $search = null,
    ?string $statut = null
)
{
    $qb = $this->createQueryBuilder('a');

    if ($user) {
        $qb->innerJoin('a.user', 'u')
           ->andWhere('u = :user')
           ->setParameter('user', $user);
    }

    if ($section) {
        $qb->innerJoin('a.section', 's')
           ->andWhere('s = :section')
           ->setParameter('section', $section);
    }

    if ($compte_c6) {
        $qb->andWhere('a.compte_c6 LIKE :compte_c6')
           ->setParameter('compte_c6','%'. $compte_c6 . '%') ;
    }
   

    if ($search) {
        $qb->andWhere('a.title LIKE :search')
           ->setParameter('search', '%' . $search . '%');
    }
    
    if ($statut) {
        $qb->andWhere('a.statut = :statut')
           ->setParameter('statut', $statut);
    }

    return $qb->getQuery()->getResult();
}


public function findBySearch($search)
{
    return $this->createQueryBuilder('a')
        ->andWhere('a.title LIKE :val')
        ->setParameter('val', '%' . $search . '%')
        ->getQuery()
        ->getResult();
}

public function findAffairesByUser(User $user)
{
    return $this->createQueryBuilder('a')
        ->andWhere('a.user = :user')
        ->setParameter('user', $user);
       
}


public function countStatut($statut)
{
    return $this->createQueryBuilder('a')
        ->select('COUNT(a.id)')
        ->andWhere('a.statut = :statut')
        ->setParameter('statut', $statut)
        ->getQuery()
        ->getSingleScalarResult();
}



public function findByUser(User $user): array
{
    $qb = $this->createQueryBuilder('a')
        ->innerJoin('a.user', 'u')
        ->where('u = :user')
        ->setParameter('user', $user);

    return $qb->getQuery()->getResult();
}

// 
public function findByAgentsSection($section)
{
    return $this->createQueryBuilder('a')
        ->join('a.user', 'u') // Utilisez 'u' comme alias pour l'utilisateur (agent)
        ->where('u.section = :section')
        ->setParameter('section', $section)
        ->getQuery()
        ->getResult();
}

// méthode pour la chart 
public function countBySection(string $sectionName)
{
    return $this->createQueryBuilder('a')
        ->select('COUNT(a.id)')
        ->join('a.section', 's')
        ->where('s.name = :sectionName')
        ->setParameter('sectionName', $sectionName)
        ->getQuery()
        ->getSingleScalarResult();
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
