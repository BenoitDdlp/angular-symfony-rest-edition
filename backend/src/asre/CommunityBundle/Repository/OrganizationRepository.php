<?php

namespace asre\CommunityBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * OrganizationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrganizationRepository extends EntityRepository
{


  /**
   * filtering with all parameters difned
   *
   * @param $qb     , query builder to add the filter to
   * @param $params , the field to filter on
   *
   * @return $qb, modified query builder
   */
  public function filter($qb, $params)
  {
    return $qb;
  }
}