<?php

namespace Illarra\ContentBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Illarra\ContentBundle\Entity\Content;
use Illarra\ContentBundle\Form\ContentType;

/**
 * @Route("/content")
 */
class ContentController extends Controller
{
    use \Illarra\CoreBundle\Traits\Controller\CoreConfiguration;
    
    /**
     * @Route("/{page}", name="admin_illarra_content_content_index", defaults={"page" = 1}, requirements={"page" = "\d+"})
     * @Method("GET")
     * @Template()
     */
    public function indexAction($page)
    {
        if ($page < 1) {
            return $this->redirect($this->generateUrl('admin_illarra_content_content_index'));
        }
        
        $repository = $this->getDoctrine()->getRepository('IllarraContentBundle:Content');
        
        if ($page > $repository->getPages()) {
            return $this->redirect($this->generateUrl('admin_illarra_content_content_index',
                array('page' => $repository->getPages()))
            );
        }
        
        return array(
            'page'              => $page,
            'pages'             => $repository->getPages(),
            'entities'          => $repository->findAllOrdered($page),
            'entities_per_page' => $repository->getEntitiesPerPage(),
            'entities_count'    => $repository->getEntitiesCount(),
        );
    }
    
    /**
     * @Route("/new", name="admin_illarra_content_content_new")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Content();
     
        if ($request->query->has('tag')) {
            $tag = $request->query->get('tag');

            // Check if already exists
            $em = $this->getDoctrine()->getManager();
            $e = $em->getRepository('IllarraContentBundle:Content')->findOneByTag($tag);

            if ($e) {
                return $this->redirect($this->generateUrl('admin_illarra_content_content_edit', ['id' => $e->getId()]));
            }

            $entity->setTag($tag);
        }

        foreach ($this->getAvailableLocales() as $locale) {
            $entity->translate($locale);
        }
        $entity->mergeNewTranslations();
        
        $form = $this->createForm(new ContentType($entity), $entity);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * @Route("/create", name="admin_illarra_content_content_create")
     * @Method("POST")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Template("IllarraContentBundle:Admin/Content:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Content();
        $form = $this->createForm(new ContentType($entity), $entity);
        $form->bind($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('admin_illarra_content_content_index'));
        }
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * @Route("/{id}/edit", name="admin_illarra_content_content_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('IllarraContentBundle:Content')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Content entity.');
        }
        
        $editForm = $this->createForm(new ContentType($entity), $entity);
        $deleteForm = $this->createDeleteForm($id);
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * @Route("/{id}/update", name="admin_illarra_content_content_update")
     * @Method("PUT")
     * @Template("IllarraContentBundle:Admin/Content:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('IllarraContentBundle:Content')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Content entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ContentType($entity), $entity);
        $editForm->bind($request);
        
        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new \DateTime('now'));
            $em->persist($entity);
            $em->flush();
        
            return $this->redirect($this->generateUrl('admin_illarra_content_content_edit', array('id' => $id)));
        }
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * @Route("/{id}/delete", name="admin_illarra_content_content_delete")
     * @Method("DELETE")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IllarraContentBundle:Content')->find($id);
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Content entity.');
            }
            
            $em->remove($entity);
            $em->flush();
        }
        
        return $this->redirect($this->generateUrl('admin_illarra_content_content_index'));
    }
    
    /**
     * @param  mixed $id
     * @return Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
