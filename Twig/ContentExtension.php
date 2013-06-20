<?php

namespace Illarra\ContentBundle\Twig;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ContentExtension extends \Twig_Extension
{
    protected $doctrine;
    
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    public function getFilters()
    {
        return array(
            'content' => new \Twig_Filter_Method($this, 'contentFilter', array(
                'is_safe' => array('html'),
            )),
        );
    }
    
    public function contentFilter($tag, $addDelimiters = true)
    {
        return $this->doctrine->getManager()->getRepository('IllarraContentBundle:Content')->getContentByTag($tag, $addDelimiters);
    }
    
    public function getName()
    {
        return 'illarra_content_extension';
    }
}
