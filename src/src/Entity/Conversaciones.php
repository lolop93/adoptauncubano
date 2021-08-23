<?php

namespace App\Entity;

use App\Repository\ConversacionesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConversacionesRepository::class)
 */
class Conversaciones
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="conversaciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $emisor;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="conversaciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $remitente;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmisor(): ?user
    {
        return $this->emisor;
    }

    public function setEmisor(?user $emisor): self
    {
        $this->emisor = $emisor;

        return $this;
    }

    public function getRemitente(): ?user
    {
        return $this->remitente;
    }

    public function setRemitente(?user $remitente): self
    {
        $this->remitente = $remitente;

        return $this;
    }
}
