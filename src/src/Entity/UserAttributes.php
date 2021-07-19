<?php

namespace App\Entity;

use App\Repository\UserAttributesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserAttributesRepository::class)
 */
class UserAttributes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $esCubano;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $color_pelo;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="atributos", cascade={"persist", "remove"})
     */
    private $usuario;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apellido1;

    /**
     * @param mixed $id
     */


    public function __toString(){
        return $this->id ;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEsCubano(): ?bool
    {
        return $this->esCubano;
    }

    public function setEsCubano(bool $esCubano): self
    {
        $this->esCubano = $esCubano;

        return $this;
    }

    public function getColorPelo(): ?string
    {
        return $this->color_pelo;
    }

    public function setColorPelo(?string $color_pelo): self
    {
        $this->color_pelo = $color_pelo;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(User $usuario): self
    {
        // set the owning side of the relation if necessary
        if ($usuario->getAtributos() !== $this) {
            $usuario->setAtributos($this);
        }

        $this->usuario = $usuario;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido1(): ?string
    {
        return $this->apellido1;
    }

    public function setApellido1(string $apellido1): self
    {
        $this->apellido1 = $apellido1;

        return $this;
    }
}
