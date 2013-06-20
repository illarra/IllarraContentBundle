<?php

namespace Illarra\ContentBundle\EventListener;

use Illarra\CoreBundle\Event\ConfigureAdminMenuEvent;

class ConfigureAdminMenuListener
{
    protected $security;

    public function __construct($security)
    {
        $this->security = $security;
    }

    /**
     * @param \Illarra\CoreBundle\Event\ConfigureAdminMenuEvent $event
     */
    public function onMenuConfigure(ConfigureAdminMenuEvent $event)
    {
        if ($this->security->isGranted('ROLE_ADMIN_CONTENT') || $this->security->isGranted('ROLE_SUPER_ADMIN')) {
            $menu = $event->getMenu();

            $menu->addChild('illarra_content', array('label' => 'menu.content.main'));
            $menu['illarra_content']->addChild('menu.content.contents', array('route' => 'admin_illarra_content_content_index'));
            $menu['illarra_content']->addChild('menu.content.variables', array('route' => 'admin_illarra_content_variable_index'));
        }
    }
}
