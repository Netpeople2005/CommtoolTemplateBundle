<?php

namespace Optime\Commtool\TemplateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Optime\Commtool\TemplateBundle\Model\TemplateInterface;

/**
 * Template
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Template implements TemplateInterface
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="view", type="string", length=255)
     */
    private $view;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=255)
     */
    private $thumbnail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
    /**
     *
     * @var @ORM\OneToMany(targetEntity="TemplateSection", mappedBy="template")
     */
    protected $sections;

    function __construct()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->createdAt = $this->updatedAt = new \DateTime();
        $this->sections = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Template
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set view
     *
     * @param string $view
     * @return Template
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return string 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Template
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return Template
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string 
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Template
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Template
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getSections()
    {
        return $this->sections;
    }


    /**
     * Add sections
     *
     * @param \Optime\Commtool\TemplateBundle\Entity\TemplateSection $sections
     * @return Template
     */
    public function addSection(\Optime\Commtool\TemplateBundle\Entity\TemplateSection $sections)
    {
        $this->sections[] = $sections;
    
        return $this;
    }

    /**
     * Remove sections
     *
     * @param \Optime\Commtool\TemplateBundle\Entity\TemplateSection $sections
     */
    public function removeSection(\Optime\Commtool\TemplateBundle\Entity\TemplateSection $sections)
    {
        $this->sections->removeElement($sections);
    }
}