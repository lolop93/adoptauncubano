<?php

namespace App\Entity;

use App\Repository\ConversacionesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="conversacionesEmisor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $emisor;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="conversacionesRemitente")
     * @ORM\JoinColumn(nullable=false)
     */
    private $remitente;

    /**
     * @ORM\OneToMany(targetEntity=Mensajes::class, mappedBy="conversacion", orphanRemoval=true)
     */
    private $mensajes;

    public function __construct()
    {
        $this->mensajes = new ArrayCollection();
    }

    public function __toString(){
        return 'Conversacion: '.$this->id .' entre '.$this->emisor.' y '.$this->remitente;
    }

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

    /**
     * @return Collection|Mensajes[]
     */
    public function getMensajes(): Collection
    {
        return $this->mensajes;
    }

    public function addMensaje(Mensajes $mensaje): self
    {
        if (!$this->mensajes->contains($mensaje)) {
            $this->mensajes[] = $mensaje;
            $mensaje->setConversacion($this);
        }

        return $this;
    }

    public function removeMensaje(Mensajes $mensaje): self
    {
        if ($this->mensajes->removeElement($mensaje)) {
            // set the owning side to null (unless already changed)
            if ($mensaje->getConversacion() === $this) {
                $mensaje->setConversacion(null);
            }
        }

        return $this;
    }
}
