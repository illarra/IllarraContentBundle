<?php

namespace Illarra\ContentBundle\Controller\Admin;

use Illarra\CoreBundle\Controller\Admin\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/content")
 */
class ContentController extends BaseController
{
    protected $label     = 'content.menu';
    protected $namespace = '\Illarra\ContentBundle';
    protected $entity    = 'IllarraContentBundle:Content';
    protected $baseRoute = 'admin_illarra_content_content';
    protected $filter    = '\Form\Filter\ContentType';

    protected function getListRow()
    {
        return function ($entity) {
            return [
                'tag'  => $entity->getTag(),
                'text' => $entity->getExcerpt(),
            ];
        };
    }

    protected function getListOrder()
    {
        return [
            'tag' => 'ASC',
        ];
    }

    protected function getFilterInstance()
    {
        // Get "tagGroups"
        $groups   = [];
        $em       = $this->getDoctrine()->getManager();
        $entities = $em->getRepository($this->entity)->findAll();

        foreach ($entities as $entity) {
            $group = explode('.', $entity->getTag())[0];
            $groups[$group] = $group;
        }

        asort($groups);

        $class = $this->getFilterClassName();
        
        return new $class(['tagGroupChoices' => $groups]);
    }

    protected function getTypeInstance()
    {
        $class = $this->getTypeClassName();        
        
        return new $class($this->container->get('security.context')->isGranted('ROLE_CONTENT_ADMIN'));
    }

    /**
     * @Secure(roles="ROLE_CONTENT_EDITOR")
     * @Route("/{page}", name="admin_illarra_content_content_index", defaults={"page" = 1}, requirements={"page" = "\d+"})
     * @Method("GET")
     */
    public function indexAction($page)
    {
        return parent::indexAction($page);
    }
    
    /**
     * @Secure(roles="ROLE_CONTENT_EDITOR")
     * @Route("/{id}/show", name="admin_illarra_content_content_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        return parent::showAction($id);
    }
    
    /**
     * @Secure(roles="ROLE_CONTENT_ADMIN")
     * @Route("/create", name="admin_illarra_content_content_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        return parent::createAction($request);
    }
    
    /**
     * @Secure(roles="ROLE_CONTENT_ADMIN")
     * @Route("/new", name="admin_illarra_content_content_new")
     * @Method("GET")
     */
    public function newAction()
    {
        return parent::newAction();
    }
    
    /**
     * @Secure(roles="ROLE_CONTENT_EDITOR")
     * @Route("/{id}/edit", name="admin_illarra_content_content_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        return parent::editAction($id);
    }
    
    /**
     * @Secure(roles="ROLE_CONTENT_EDITOR")
     * @Route("/{id}/update", name="admin_illarra_content_content_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        return parent::updateAction($request, $id);
    }
    
    /**
     * @Secure(roles="ROLE_CONTENT_ADMIN")
     * @Route("/{id}/delete", name="admin_illarra_content_content_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        return parent::deleteAction($request, $id);
    }
}

