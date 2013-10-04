<?php

namespace Illarra\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentType extends AbstractType
{
    private $userIsAdmin;

    public function __construct($userIsAdmin)
    {
        $this->userIsAdmin = $userIsAdmin;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();

        if ($this->userIsAdmin) {
            $builder->add('tag');
        } else {
            $builder->remove('tag');
        }

        $builder->add('translations', 'translations', [
            'type' => new ContentTranslationType($entity->getType()),
        ]);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Illarra\ContentBundle\Entity\Content'
        ));
    }
    
    public function getName()
    {
        return 'illarra_contentbundle_contenttype';
    }
}
