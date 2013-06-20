<?php

namespace Illarra\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentTranslationType extends AbstractType
{
    protected $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('locale', 'hidden');

        switch ($this->entity->getType()) {
            case 'markdown':
                $builder->add('text', null, ['label' => 'content.label.text', 'attr' => ['class' => 'js-markdown']]);
            break;
            default:
                $builder->add('text', null, ['label' => 'content.label.text']);
            break;
        }
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Illarra\ContentBundle\Entity\ContentTranslation'
        ));
    }
    
    public function getName()
    {
        return 'illarra_contentbundle_contenttranslationtype';
    }
}
