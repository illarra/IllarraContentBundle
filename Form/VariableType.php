<?php

namespace Illarra\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VariableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tag', null, ['label' => 'variable.label.tag'])
            ->add('text', 'text', ['label' => 'variable.label.text'])
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Illarra\ContentBundle\Entity\Variable'
        ));
    }
    
    public function getName()
    {
        return 'illarra_contentbundle_variabletype';
    }
}
