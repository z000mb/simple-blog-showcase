<?php

namespace App\Repository;

use App\Dto\Paginator\PaginatorDto;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @param Post $entity
     * @param bool $flush
     * @return void
     */
    public function add(Post $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findAllPosts(PaginatorDto $paginator): array
    {
        $qb = $this->createQueryBuilder("post")
            ->orderBy("post.createdAt", "DESC");

        $totalItems = (new Paginator($qb, true))
            ->count();
        $totalPages = (int)ceil($totalItems / $paginator->getPageSize());
        $firstResult = ($paginator->getPageNumber() - 1) * $paginator->getPageSize();

        $qb
            ->setFirstResult($firstResult)
            ->setMaxResults($paginator->getPageSize());

        $paginator
            ->setTotalItems($totalItems)
            ->setTotalPages($totalPages);

        return $qb->getQuery()
            ->getResult();
    }
}
