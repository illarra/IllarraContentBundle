<?php

namespace Illarra\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
            ->add('source', 'hidden')
            ->add('file', 'file', [
                'required' => false,
                'constraints' => [new Assert\Image(['maxSize' => $this->getImageMaxSize()])],
            ])
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\BlogBundle\Entity\Image'
        ]);
    }
    
    public function getName()
    {
        return 'illarra_contentbundle_imagetype';
    }
    
    public function getImageMaxSize()
    {
        return 6291456;
    }
}
