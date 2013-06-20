<?php

namespace Illarra\ContentBundle\Entity;

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
