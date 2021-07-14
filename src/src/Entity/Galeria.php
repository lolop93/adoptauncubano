<?php

namespace App\Entity;

use App\Repository\GaleriaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GaleriaRepository::class)
 */
class Galeria
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $foto_perfil;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $galeria = [];

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="galeria", cascade={"persist", "remove"})
     */
    private $usuario;

    public function __toString(){
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFotoPerfil(): ?string
    {
        return $this->foto_perfil;
    }

    public function setFotoPerfil(?string $foto_perfil): self
    {
        $this->foto_perfil = $foto_perfil;

        return $this;
    }

    public function getGaleria(): ?array
    {
        return $this->galeria;
    }

    public function setGaleria(?array $galeria): self
    {
        $this->galeria = $galeria;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(User $usuario): self
    {
        // set the owning side of the relation if necessary
        if ($usuario->getGaleria() !== $this) {
            $usuario->setGaleria($this);
        }

        $this->usuario = $usuario;

        return $this;
    }
}
