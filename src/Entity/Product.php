<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Config", mappedBy="product", orphanRemoval=true)
     */
    private $config;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->config = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->getName();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Config[]
     */
    public function getConfig(): Collection
    {
        return $this->config;
    }

    public function addConfig(Config $config): self
    {
        if (!$this->config->contains($config)) {
            $this->config[] = $config;
            $config->setProduct($this);
        }

        return $this;
    }

    public function removeConfig(Config $config): self
    {
        if ($this->config->contains($config)) {
            $this->config->removeElement($config);
            // set the owning side to null (unless already changed)
            if ($config->getProduct() === $this) {
                $config->setProduct(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
