<?php

namespace Illarra\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentType extends AbstractType
{
    protected $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tag', null, ['label' => 'content.label.tag'])
            ->add('translations', 'collection', array(
                'cascade_validation' => true,
                'type' => new ContentTranslationType($this->entity),
                'allow_add' => true,
                'by_reference' => false,
                'options' => array(
                    'data_class' => 'Illarra\ContentBundle\Entity\ContentTranslation',
                )
            ))
        ;
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
