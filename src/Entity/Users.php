<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $screenname;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Movings", cascade={"persist", "remove"})
     */
    private $defaultMoving;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UsersMovings", mappedBy="user", orphanRemoval=true)
     */
    private $movings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rooms", mappedBy="user")
     */
    private $rooms;

    public function __construct()
    {
        $this->movings = new ArrayCollection();
        $this->rooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getScreenname(): ?string
    {
        return $this->screenname;
    }

    public function setScreenname(string $screenname): self
    {
        $this->screenname = $screenname;

        return $this;
    }

    public function getDefaultMoving(): ?Movings
    {
        return $this->defaultMoving;
    }

    public function setDefaultMoving(?Movings $defaultMoving): self
    {
        $this->defaultMoving = $defaultMoving;

        return $this;
    }

    /**
     * @return Collection|UsersMovings[]
     */
    public function getMovings(): Collection
    {
        return $this->movings;
    }

    public function addMoving(UsersMovings $moving): self
    {
        if (!$this->movings->contains($moving)) {
            $this->movings[] = $moving;
            $moving->setUser($this);
        }

        return $this;
    }

    public function removeMoving(UsersMovings $moving): self
    {
        if ($this->movings->contains($moving)) {
            $this->movings->removeElement($moving);
            // set the owning side to null (unless already changed)
            if ($moving->getUser() === $this) {
                $moving->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rooms[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Rooms $room): self
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms[] = $room;
            $room->setUser($this);
        }

        return $this;
    }

    public function removeRoom(Rooms $room): self
    {
        if ($this->rooms->contains($room)) {
            $this->rooms->removeElement($room);
            // set the owning side to null (unless already changed)
            if ($room->getUser() === $this) {
                $room->setUser(null);
            }
        }

        return $this;
    }
}
