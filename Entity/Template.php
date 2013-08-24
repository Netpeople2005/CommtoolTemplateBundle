<?php

namespace Optime\Commtool\TemplateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Optime\Commtool\TemplateBundle\Entity\TemplateSection;
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
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

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
     * @var ArrayCollection
     * @var @ORM\OneToMany(targetEntity="TemplateSection", mappedBy="template", orphanRemoval=true, cascade={"persist"})
     */
    protected $sections;

    /**
     * @var ArrayCollection
     * @var @ORM\OneToMany(targetEntity="\Optime\Promowin\PromotionsBundle\Entity\PromotionTemplate", mappedBy="template", orphanRemoval=true, cascade={"persist"})
     */
    protected $promotion_template;

    /**
     * @var \Optime\Promowin\PromotionsBundle\Entity\Hotspot
     * @var @ORM\OneToOne(targetEntity="\Optime\Promowin\PromotionsBundle\Entity\Hotspot", mappedBy="template", orphanRemoval=true, cascade={"persist"})
     */
    protected $hotspot;

    function __construct()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->sections = new ArrayCollection();
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
     * @param TemplateSection $section
     * @return Template
     */
    public function addSection(TemplateSection $section)
    {
        $this->sections->add($section);

        return $this;
    }

    /**
     * Remove sections
     *
     * @param TemplateSection $sections
     */
    public function removeSection(TemplateSection $sections)
    {
        $this->sections->removeElement($sections);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Template
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    public function setSections($sections, TemplateSection $parent = null)
    {
        foreach ($sections as $data) {
            $section = new TemplateSection();

            if ($parent) {
                if ('loop' === $parent->getType()) {
                    $section->setCompleteIdentifier($parent->getIdentifier() . '.' . $data['id']);
                } else {
                    $section->setCompleteIdentifier($parent
                                    ->getCompleteIdentifier() . '.' . $data['id']);
                }
            } else {
                $section->setCompleteIdentifier($data['id']);
            }

            $section->setName($data['name'])
                    ->setType($data['type'])
                    ->setTemplate($this)
                    ->setParent($parent)
                    ->setIdentifier($data['id'])
                    ->setConfig(isset($data['config']) ? $data['config'] : array());

            $this->sections->add($section);

            if (isset($data['children']) and count($data['children'])) {
                $this->setSections($data['children'], $section);
            }
        }
    }

    public function getSection($id, $sections = null)
    {
        if (null === $sections) {
            $sections = $this->getSections();
        }

        foreach ($sections as $section) {
            if ($id === $section->getIdentifier()) {
                return $section;
            }
            if (null !== $result = $this->getSection($id, $section->getChildren())) {
                return $result;
            }
        }

        return null;
    }

    /**
     * Add promotion_template
     *
     * @param \Optime\Promowin\PromotionsBundle\Entity\PromotionTemplate $promotionTemplate
     * @return Template
     */
    public function addPromotionTemplate(\Optime\Promowin\PromotionsBundle\Entity\PromotionTemplate $promotionTemplate)
    {
        $this->promotion_template[] = $promotionTemplate;

        return $this;
    }

    /**
     * Remove promotion_template
     *
     * @param \Optime\Promowin\PromotionsBundle\Entity\PromotionTemplate $promotionTemplate
     */
    public function removePromotionTemplate(\Optime\Promowin\PromotionsBundle\Entity\PromotionTemplate $promotionTemplate)
    {
        $this->promotion_template->removeElement($promotionTemplate);
    }

    /**
     * Get promotion_template
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPromotionTemplate()
    {
        return $this->promotion_template;
    }

    /**
     * Get hotspot
     *
     * @return \Optime\Promowin\PromotionsBundle\Entity\Hotspot 
     */
    public function getHotspot()
    {
        return $this->hotspot;
    }

    /**
     * Set hotspot
     *
     * @param \Optime\Promowin\PromotionsBundle\Entity\Hotspot $hotspot
     * @return Template
     */
    public function setHotspot(\Optime\Promowin\PromotionsBundle\Entity\Hotspot $hotspot = null)
    {
        $this->hotspot = $hotspot;

        return $this;
    }

}