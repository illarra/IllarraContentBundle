<?php

namespace Illarra\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Illarra\ContentBundle\Repository\Variable")
 * @ORM\Table(name="content_variable")
 */
class Variable
{
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $tag;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $text;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param string $tag
     * @return Variable
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        
        return $this;
    }
    
    /**
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }
    
    /**
     * @param string $text
     * @return Variable
     */
    public function setText($text)
    {
        $this->text = $text;
        
        return $this;
    }
    
    /**
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }
}
