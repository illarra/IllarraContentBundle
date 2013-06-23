<?php

namespace Illarra\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;

class Variable extends EntityRepository
{
    use \Illarra\CoreBundle\Traits\Repository\Paginator;
    
    public function getOrderFields()
    {
        return ['tag ASC'];
    }
}
