<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovingsRepository")
 */
class Movings
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UsersMovings", mappedBy="moving", orphanRemoval=true)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Boxes", mappedBy="moving", orphanRemoval=true)
     */
    private $boxes;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->boxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|UsersMovings[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(UsersMovings $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setMoving($this);
        }

        return $this;
    }

    public function removeUser(UsersMovings $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getMoving() === $this) {
                $user->setMoving(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Boxes[]
     */
    public function getBoxes(): Collection
    {
        return $this->boxes;
    }

    public function addBox(Boxes $box): self
    {
        if (!$this->boxes->contains($box)) {
            $this->boxes[] = $box;
            $box->setMoving($this);
        }

        return $this;
    }

    public function removeBox(Boxes $box): self
    {
        if ($this->boxes->contains($box)) {
            $this->boxes->removeElement($box);
            // set the owning side to null (unless already changed)
            if ($box->getMoving() === $this) {
                $box->setMoving(null);
            }
        }

        return $this;
    }
}
