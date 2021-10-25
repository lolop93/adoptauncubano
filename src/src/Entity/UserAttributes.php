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
     * @ORM\Column(type="boolean", nullable=true)
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
    private $nacionalidad;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_nac;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ojos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profesion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ciudad;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $altura;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $peso;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $gustos = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexo;


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

    public function getNacionalidad(): ?string
    {
        return $this->nacionalidad;
    }

    public function setNacionalidad(?string $nacionalidad): self
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    public function getFechaNac(): ?\DateTimeInterface
    {
        return $this->fecha_nac;
    }

    public function setFechaNac(?\DateTimeInterface $fecha_nac): self
    {
        $this->fecha_nac = $fecha_nac;

        return $this;
    }

    public function getOjos(): ?string
    {
        return $this->ojos;
    }

    public function setOjos(?string $ojos): self
    {
        $this->ojos = $ojos;

        return $this;
    }

    public function getProfesion(): ?string
    {
        return $this->profesion;
    }

    public function setProfesion(?string $profesion): self
    {
        $this->profesion = $profesion;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(?string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getAltura(): ?int
    {
        return $this->altura;
    }

    public function setAltura(?int $altura): self
    {
        $this->altura = $altura;

        return $this;
    }

    public function getPeso(): ?int
    {
        return $this->peso;
    }

    public function setPeso(?int $peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    public function getGustos(): ?array
    {
        return $this->gustos;
    }

    public function setGustos(?array $gustos): self
    {
        $this->gustos = $gustos;

        return $this;
    }

    public function getSexo(): ?string
    {
        return $this->sexo;
    }

    public function setSexo(?string $sexo): self
    {
        $this->sexo = $sexo;

        return $this;
    }

}
