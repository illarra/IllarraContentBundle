<?php

namespace Illarra\ContentBundle\Entity;

use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\ORM\EntityRepository;

class Content extends EntityRepository
{
    use \Illarra\CoreBundle\Traits\Repository\Paginator;
    
    private $markdown;

    /**
     * @DI\InjectParams({"markdown" = @DI\Inject("markdown.parser")})
     */
    public function setMarkdownService($markdown)
    {
        $this->markdown = $markdown;
    }

    public function getOrderFields()
    {
        return ['tag ASC'];
    }

    public function getContentByTag($tag, $addDelimiters = true, $locale = null)
    {
        $entity = $this->findOneByTag($tag);

        if (!$entity) {
            $entity = new Content();
            $entity->setTag($tag);
        }

        if (!is_null($locale)) {
            $entity->setCurrentLocale($locale);
        }

        switch ($entity->getType()) {
            case 'markdown':
                $content = $this->markdown->transformMarkdown($entity->getText());
            break;
            default:
                $content = $entity->getText();
            break;
        }

        if ($addDelimiters) {
            return 
            '<!-- (( content:' . $tag . ' ' . json_encode(['id' => $entity->getId()]) . ' -->' . 
                $content .
            '<!-- content:' . $tag . ' )) -->';
        } else {
            return $content;
        }
    }
}
