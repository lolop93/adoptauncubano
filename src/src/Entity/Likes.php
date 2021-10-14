<?php

namespace App\Entity;

use App\Repository\LikesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikesRepository::class)
 */
class Likes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="likesRecibidos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $likesTo;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="likesDados")
     * @ORM\JoinColumn(nullable=false)
     */
    private $likesFrom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(){
        return $this->id ;
    }

    public function getLikesTo(): ?User
    {
        return $this->likesTo;
    }

    public function setLikesTo(?User $likesTo): self
    {
        $this->likesTo = $likesTo;

        return $this;
    }

    public function getLikesFrom(): ?User
    {
        return $this->likesFrom;
    }

    public function setLikesFrom(?User $likesFrom): self
    {
        $this->likesFrom = $likesFrom;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }
}
