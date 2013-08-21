<?php

namespace Optime\Commtool\TemplateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Image
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
     * @var string
     *
     * @ORM\Column(name="large", type="string", length=255)
     */
    private $large;

    /**
     * @var string
     *
     * @ORM\Column(name="medium", type="string", length=255)
     */
    private $medium;

    /**
     * @var string
     *
     * @ORM\Column(name="small", type="string", length=255)
     */
    private $small;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;
    
//    /**
//     *
//     * @var \Doctrine\Common\Collections\ArrayCollection
//     * @ORM\ManyToMany
//     */
//    protected $sectionGallery;

    function __construct()
    {
        $this->status = 1;
    }

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
     * Set template
     *
     * @param string $template
     * @return Image
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string 
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set large
     *
     * @param string $large
     * @return Image
     */
    public function setLarge($large)
    {
        $this->large = $large;

        return $this;
    }

    /**
     * Get large
     *
     * @return string 
     */
    public function getLarge()
    {
        return $this->large;
    }

    /**
     * Set medium
     *
     * @param string $medium
     * @return Image
     */
    public function setMedium($medium)
    {
        $this->medium = $medium;

        return $this;
    }

    /**
     * Get medium
     *
     * @return string 
     */
    public function getMedium()
    {
        return $this->medium;
    }

    /**
     * Set small
     *
     * @param string $small
     * @return Image
     */
    public function setSmall($small)
    {
        $this->small = $small;

        return $this;
    }

    /**
     * Get small
     *
     * @return string 
     */
    public function getSmall()
    {
        return $this->small;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Image
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

}