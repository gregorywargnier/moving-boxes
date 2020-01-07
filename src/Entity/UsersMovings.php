<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersMovingsRepository")
 */
class UsersMovings
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movings", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $moving;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="movings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Roles")
     */
    private $roles;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoving(): ?Movings
    {
        return $this->moving;
    }

    public function setMoving(?Movings $moving): self
    {
        $this->moving = $moving;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRoles(): ?Roles
    {
        return $this->roles;
    }

    public function setRoles(?Roles $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
