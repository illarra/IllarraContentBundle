<?php

namespace Illarra\ContentBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Illarra\ContentBundle\Entity\Variable;
use Illarra\ContentBundle\Form\VariableType;

/**
 * @Route("/variable")
 */
class VariableController extends Controller
{
    use \Illarra\CoreBundle\Traits\Controller\CoreConfiguration;
    
    /**
     * @Route("/{page}", name="admin_illarra_content_variable_index", defaults={"page" = 1}, requirements={"page" = "\d+"})
     * @Method("GET")
     * @Template()
     */
    public function indexAction($page)
    {
        if ($page < 1) {
            return $this->redirect($this->generateUrl('admin_illarra_content_variable_index'));
        }
        
        $repository = $this->getDoctrine()->getRepository('IllarraContentBundle:Variable');
        $repository->setEntitiesPerPage($this->getEntitiesPerPageInAdmin());
        
        if ($page > $repository->getPages()) {
            return $this->redirect($this->generateUrl('admin_illarra_content_variable_index',
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
     * @Route("/new", name="admin_illarra_content_variable_new")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Variable();
        
        $form = $this->createForm(new VariableType(), $entity);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * @Route("/create", name="admin_illarra_content_variable_create")
     * @Method("POST")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Template("IllarraContentBundle:Admin/Variable:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Variable();
        
        $form = $this->createForm(new VariableType(), $entity);
        $form->bind($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('admin_illarra_content_variable_edit', array('id' => $entity->getId())));
        }
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * @Route("/{id}/edit", name="admin_illarra_content_variable_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('IllarraContentBundle:Variable')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Variable entity.');
        }
        
        $editForm = $this->createForm(new VariableType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * @Route("/{id}/update", name="admin_illarra_content_variable_update")
     * @Method("PUT")
     * @Template("IllarraContentBundle:Admin/Variable:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('IllarraContentBundle:Variable')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Variable entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VariableType(), $entity);
        $editForm->bind($request);
        
        if ($editForm->isValid()) {
            $entity->setUpdatedAt(new \DateTime('now'));
            $em->persist($entity);
            $em->flush();
        
            return $this->redirect($this->generateUrl('admin_illarra_content_variable_edit', array('id' => $id)));
        }
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * @Route("/{id}/delete", name="admin_illarra_content_variable_delete")
     * @Secure(roles="ROLE_SUPER_ADMIN")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IllarraContentBundle:Variable')->find($id);
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Variable entity.');
            }
            
            $em->remove($entity);
            $em->flush();
        }
        
        return $this->redirect($this->generateUrl('admin_illarra_content_variable_index'));
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
