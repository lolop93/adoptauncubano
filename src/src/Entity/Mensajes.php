<?php

namespace App\Entity;

use App\Repository\MensajesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MensajesRepository::class)
 */
class Mensajes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $texto;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=Conversaciones::class, inversedBy="mensajes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $conversacion;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="mensajes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString(): string
    {
        return $this->texto;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;

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

    public function getConversacion(): ?Conversaciones
    {
        return $this->conversacion;
    }

    public function setConversacion(?Conversaciones $conversacion): self
    {
        $this->conversacion = $conversacion;

        return $this;
    }

    public function getUsuario(): ?user
    {
        return $this->usuario;
    }

    public function setUsuario(?user $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }
}
