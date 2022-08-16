<?php

namespace App\Entity;

use App\Repository\PeopleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeopleRepository::class)]
class People
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $contact = [];

    #[ORM\Column]
    private array $address = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContact(): array
    {
        return $this->contact;
    }

    public function setContact(array $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getAddress(): array
    {
        return $this->address;
    }

    public function setAddress(array $address): self
    {
        $this->address = $address;

        return $this;
    }
}
