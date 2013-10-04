<?php

namespace Illarra\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentTranslationType extends AbstractType
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('locale', 'hidden');

        switch ($this->type) {
            case 'markdown':
                $builder->add('text', null, [
                    'label' => false,
                    'attr'  => ['class' => 'js-markdown'],
                ]);
            break;
            case 'yaml':
                $builder->add('text', null, [
                    'label' => false,
                    'attr'  => ['class' => 'js-yaml'],
                ]);
            break;
            default:
                $builder->add('text', null, ['label' => false]);
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
