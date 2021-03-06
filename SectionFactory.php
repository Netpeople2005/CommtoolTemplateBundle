<?php

namespace Optime\Commtool\TemplateBundle;

use Symfony\Component\DependencyInjection\ContainerInterface;

class SectionFactory
{

    /**
     *
     * @var ContainerInterface
     */
    protected $container;
    protected $validSections;
    protected $sections = array();

    function __construct(ContainerInterface $container, array $validSections = array())
    {
        $this->container = $container;
        $this->validSections = $validSections;
    }

    public function getTypes()
    {
        return array_keys($this->validSections);
    }

    public function getType($name)
    {
        if (!isset($this->validSections[$name])) {
            throw new \Exception("No existe la sección de nombre $name");
        }

        if (count($this->sections)) {
            return $this->sections[$this->validSections[$name]];
        }
        return $this->container->get($this->validSections[$name]);
    }

    public function getSections()
    {
        if (count($this->sections) === 0) {
            foreach ($this->validSections as $name => $serviceId) {
                $this->sections[$name] = $this->container->get($this->validSections[$name]);
            }
        }

        return $this->sections;
    }

}
