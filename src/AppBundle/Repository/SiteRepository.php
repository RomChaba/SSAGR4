<?php

namespace AppBundle\Repository;

/**
 * SiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SiteRepository extends \Doctrine\ORM\EntityRepository
{
    public function deleteAllSite()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->delete()
            ->getQuery()
            ->execute();
    }
}
