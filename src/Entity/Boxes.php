<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoxesRepository")
 */
class Boxes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movings", inversedBy="boxes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $moving;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rooms")
     */
    private $origin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rooms")
     */
    private $destination;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
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

    public function getOrigin(): ?Rooms
    {
        return $this->origin;
    }

    public function setOrigin(?Rooms $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getDestination(): ?Rooms
    {
        return $this->destination;
    }

    public function setDestination(?Rooms $destination): self
    {
        $this->destination = $destination;

        return $this;
    }
}
