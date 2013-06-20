<?php

namespace Illarra\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="content_translation")
 */
class ContentTranslation
{
    use \Knp\DoctrineBehaviors\Model\Translatable\Translation;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $text;
    
    /**
     * @param string $text
     * @return ContentTranslation
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
