<?php

namespace Illarra\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Illarra\EventBundle\Entity\Event;

class LoadEventData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Events
        
        $event1 = new Event();
        $event1
            ->setTitle('title')
            ->setExcerpt('excerpt')
            ->setText('text')
        ;
        $manager->persist($event1);
        
        $manager->flush();
    }
}
