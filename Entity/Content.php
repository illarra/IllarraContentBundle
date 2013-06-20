<?php

namespace Illarra\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Illarra\ContentBundle\Repository\Content")
 * @ORM\Table(name="content")
 */
class Content
{
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable,
        \Knp\DoctrineBehaviors\Model\Translatable\Translatable;
    
    public function __call($method, $arguments)
    {
        $method = in_array($method, ['text'])
            ? 'get'.$method
            : $method;
        
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
    
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
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param string $tag
     * @return Content
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

    public function getType()
    {
        $extension = pathinfo($this->getTag(), PATHINFO_EXTENSION);

        switch (strtolower($extension)) {
            case 'md':
                return 'markdown';
            break;
            default:
                return 'text';
            break;
        }
    }
}
