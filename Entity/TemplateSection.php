<?php

namespace Optime\Commtool\TemplateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Optime\Commtool\TemplateBundle\Model\SectionConfigInterface;

/**
 * TemplateSection
 *
 * @ORM\Table(name="template_section")
 * @ORM\Entity
 */
class TemplateSection implements SectionConfigInterface
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=100)
     */
    private $identifier;

    /**
     * @var string
     *
     * @ORM\Column(name="complete_identifier", type="string", length=250)
     */
    private $completeIdentifier;

    /**
     * @var array
     *
     * @ORM\Column(name="config", type="array")
     */
    private $config;

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
     * @var @ORM\ManyToOne(targetEntity="Template", inversedBy="sections")
     */
    protected $template;

    /**
     *
     * @var @ORM\ManyToOne(targetEntity="TemplateSection", inversedBy="children")
     */
    protected $parent;

    /**
     *
     * @var @ORM\OneToMany(targetEntity="TemplateSection", mappedBy="parent", cascade={"remove"})
     */
    protected $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = $this->updatedAt = new \DateTime();
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
     * @return TemplateSection
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
     * Set identifier
     *
     * @param string $identifier
     * @return TemplateSection
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string 
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set config
     *
     * @param array $config
     * @return TemplateSection
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config
     *
     * @return array 
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return TemplateSection
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
     * @return TemplateSection
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

    /**
     * Set template
     *
     * @param \Optime\Commtool\TemplateBundle\Entity\Template $template
     * @return TemplateSection
     */
    public function setTemplate(\Optime\Commtool\TemplateBundle\Entity\Template $template = null)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return \Optime\Commtool\TemplateBundle\Entity\Template 
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set parent
     *
     * @param \Optime\Commtool\TemplateBundle\Entity\TemplateSection $parent
     * @return TemplateSection
     */
    public function setParent(\Optime\Commtool\TemplateBundle\Entity\TemplateSection $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Optime\Commtool\TemplateBundle\Entity\TemplateSection 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \Optime\Commtool\TemplateBundle\Entity\TemplateSection $children
     * @return TemplateSection
     */
    public function addChildren(\Optime\Commtool\TemplateBundle\Entity\TemplateSection $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Optime\Commtool\TemplateBundle\Entity\TemplateSection $children
     */
    public function removeChildren(\Optime\Commtool\TemplateBundle\Entity\TemplateSection $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }


    /**
     * Add children
     *
     * @param \Optime\Commtool\TemplateBundle\Entity\TemplateSection $children
     * @return TemplateSection
     */
    public function addChild(\Optime\Commtool\TemplateBundle\Entity\TemplateSection $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Optime\Commtool\TemplateBundle\Entity\TemplateSection $children
     */
    public function removeChild(\Optime\Commtool\TemplateBundle\Entity\TemplateSection $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Set completeIdentifier
     *
     * @param string $completeIdentifier
     * @return TemplateSection
     */
    public function setCompleteIdentifier($completeIdentifier)
    {
        $this->completeIdentifier = $completeIdentifier;

        return $this;
    }

    /**
     * Get completeIdentifier
     *
     * @return string 
     */
    public function getCompleteIdentifier()
    {
        return $this->completeIdentifier;
    }
}
