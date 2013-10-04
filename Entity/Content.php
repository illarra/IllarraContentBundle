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
        \Knp\DoctrineBehaviors\Model\Translatable\Translatable,
        \Illarra\CoreBundle\Traits\Helper\Truncate;

    public function __toString()
    {
        return $this->getTag();
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

    /**
     * @return string
     */
    public function getText()
    {
        return $this->proxyCurrentLocaleTranslation('getText');
    }

    /**
     * @return string
     */
    public function getExcerpt($length = 90)
    {
        return $this->truncate('getText', $length);
    }

    /**
     * @return string
     */
    public function getType()
    {
        $extension = pathinfo($this->getTag(), PATHINFO_EXTENSION);

        switch (strtolower($extension)) {
            case 'md':
                return 'markdown';
            break;
            case 'yml':
            case 'yaml':
                return 'yaml';
            break;
            default:
                return 'text';
            break;
        }
    }
}
