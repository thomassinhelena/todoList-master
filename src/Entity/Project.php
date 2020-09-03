<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=Tasks::class, mappedBy="Project")
     */
    private $Status;

    public function __construct()
    {
        $this->Status = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Tasks[]
     */
    public function getStatus(): Collection
    {
        return $this->Status;
    }

    public function addStatus(Tasks $status): self
    {
        if (!$this->Status->contains($status)) {
            $this->Status[] = $status;
            $status->setProject($this);
        }

        return $this;
    }

    public function removeStatus(Tasks $status): self
    {
        if ($this->Status->contains($status)) {
            $this->Status->removeElement($status);
            // set the owning side to null (unless already changed)
            if ($status->getProject() === $this) {
                $status->setProject(null);
            }
        }

        return $this;
    }
}
