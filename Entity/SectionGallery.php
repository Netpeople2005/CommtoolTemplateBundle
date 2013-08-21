<?php

namespace Optime\Commtool\TemplateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SectionGallery
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SectionGallery
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     *
     * @var TemplateSection
     * @ORM\OneToOne(targetEntity="TemplateSection")
     */
    protected $section;
    
    /**
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity="Image")
     */
    protected $images;


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
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set section
     *
     * @param \Optime\Commtool\TemplateBundle\Entity\TemplateSection $section
     * @return SectionGallery
     */
    public function setSection(\Optime\Commtool\TemplateBundle\Entity\TemplateSection $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \Optime\Commtool\TemplateBundle\Entity\TemplateSection 
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Add images
     *
     * @param \Optime\Commtool\TemplateBundle\Entity\Image $images
     * @return SectionGallery
     */
    public function addImage(\Optime\Commtool\TemplateBundle\Entity\Image $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Optime\Commtool\TemplateBundle\Entity\Image $images
     */
    public function removeImage(\Optime\Commtool\TemplateBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}