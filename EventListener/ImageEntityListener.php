<?php

namespace Illarra\ContentBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Illarra\ContentBundle\Entity\Image;

class ImageEntityListener
{
    protected $kernel;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    protected function setProjectRoot(LifecycleEventArgs $args)
    {
        $entity         = $args->getEntity();
        $entityManager  = $args->getEntityManager();

        if ($entity instanceof Image) {
            $entity->setProjectRoot(realpath($this->kernel->getRootDir() . '/..'));
        }
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $this->setProjectRoot($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->setProjectRoot($args);
    }
}