<?php

namespace Illarra\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;

class Image extends EntityRepository
{
    use \Illarra\CoreBundle\Traits\Repository\Paginator,
        \Knp\DoctrineBehaviors\ORM\Sortable\SortableRepository;
    
    public function getOrderFields()
    {
        return ['sort ASC'];
    }
}
