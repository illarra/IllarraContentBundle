<?php

namespace Illarra\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable,
        \Knp\DoctrineBehaviors\Model\Sortable\Sortable,
        \Illarra\CoreBundle\Traits\Entity\Featured,
        \Illarra\CoreBundle\Traits\Entity\Visible;

    protected $projectRoot;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $path;
    protected $file;

    /**
     * @param integer $id
     * @return Image
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }

    /**
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;
        
        return $this;
    }

    /**
     * @param string $file
     * @return Image
     */
    public function setFile($file)
    {
        $this->file = $file;
        
        return $this;
    }
    
    public function setProjectRoot($path)
    {
        $this->projectRoot = $path;
    }

    /**
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }
    
    public function setSource()
    {
    }
    
    /**
     * @return string
     */
    public function getSource()
    {
        $subdir = trim($this->getImageSubdir(), ' \/');
        $subdir = !empty($subdir) ? "$subdir/" : '/';

        return null === $this->path
            ? null
            : 'image/' . $subdir . $this->path;
    }
    
    /**
     * @return string
     */
    protected function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir() . '/' . $this->path;
    }
    
    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        return $this->projectRoot . '/uploads/image/' . trim($this->getImageSubdir(), ' \/');
    }
    
    /**
     * @return string
     */
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return trim('uploads/image/' . trim($this->getImageSubdir(), ' \/'), ' \/');
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename . '.' . $this->file->guessExtension();
        }
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
        
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->path);
        
        unset($this->file);
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
    
    /**
     * @return string 
     */
    protected function getImageSubdir()
    {
        return '';
    }
}