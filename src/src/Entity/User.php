<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apellido1;


    /**
     * @ORM\OneToOne(targetEntity=Galeria::class, inversedBy="usuario", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $galeria;

    /**
     * @ORM\OneToOne(targetEntity=UserAttributes::class, inversedBy="usuario", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $atributos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isVerified = false;


    /**
     * @ORM\OneToMany(targetEntity=Conversaciones::class, mappedBy="emisor")
     */
    private $conversacionesEmisor; //cuando el propio usuario es el que inicia la conversacion

    /**
     * @ORM\OneToMany(targetEntity=Conversaciones::class, mappedBy="remitente")
     */
    private $conversacionesRemitente; //cuando es el otro usuario es el que inicia la conversacion


    /**
     * @ORM\OneToMany(targetEntity=Mensajes::class, mappedBy="usuario", orphanRemoval=true)
     */
    private $mensajes;

    /**
     * @ORM\OneToMany(targetEntity=Likes::class, mappedBy="likesTo")
     */
    private $likesRecibidos;


    /**
     * @ORM\OneToMany(targetEntity=Likes::class, mappedBy="likesFrom")
     */
    private $likesDados;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $horaconexion;

    public function __construct()
    {
        $this->conversacionesEmisor = new ArrayCollection();
        $this->conversacionesRemitente = new ArrayCollection();
        $this->mensajes = new ArrayCollection();
        $this->likesRecibidos = new ArrayCollection();
        $this->likesDados = new ArrayCollection();
    }

    public function __toString(){
        return $this->id .' '.$this->username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getGaleria(): ?Galeria
    {
        return $this->galeria;
    }

    public function setGaleria(Galeria $galeria): self
    {
        $this->galeria = $galeria;

        return $this;
    }

    public function getAtributos(): ?UserAttributes
    {
        return $this->atributos;
    }

    public function setAtributos(UserAttributes $atributos): self
    {
        $this->atributos = $atributos;

        return $this;
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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

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

    /**
     * @return Collection|Conversaciones[]
     */
    public function getConversacionesEmisor(): Collection
    {
        return $this->conversacionesEmisor;
    }

    public function addConversacionEmisor(Conversaciones $conversacion): self
    {
        if (!$this->conversacionesEmisor->contains($conversacion)) {
            $this->conversacionesEmisor[] = $conversacion;
            $conversacion->setEmisor($this);
        }

        return $this;
    }

    public function removeConversacionEmisor(Conversaciones $conversacion): self
    {
        if ($this->conversacionesEmisor->removeElement($conversacion)) {
            // set the owning side to null (unless already changed)
            if ($conversacion->getEmisor() === $this) {
                $conversacion->setEmisor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Conversaciones[]
     */
    public function getConversacionesRemitente(): Collection
    {
        return $this->conversacionesRemitente;
    }

    public function addConversacionRemitente(Conversaciones $conversacion): self
    {
        if (!$this->conversacionesRemitente->contains($conversacion)) {
            $this->conversacionesRemitente[] = $conversacion;
            $conversacion->setEmisor($this);
        }

        return $this;
    }

    public function removeConversacionRemitente(Conversaciones $conversacion): self
    {
        if ($this->conversacionesRemitente->removeElement($conversacion)) {
            // set the owning side to null (unless already changed)
            if ($conversacion->getReceptor() === $this) {
                $conversacion->setReceptor(null);
            }
        }

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
            $mensaje->setUsuario($this);
        }

        return $this;
    }

    public function removeMensaje(Mensajes $mensaje): self
    {
        if ($this->mensajes->removeElement($mensaje)) {
            // set the owning side to null (unless already changed)
            if ($mensaje->getUsuario() === $this) {
                $mensaje->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Likes[]
     */
    public function getLikesRecibidos(): Collection
    {
        return $this->likesRecibidos;
    }

    public function addLikesRecibido(Likes $likesRecibido): self
    {
        if (!$this->likesRecibidos->contains($likesRecibido)) {
            $this->likesRecibidos[] = $likesRecibido;
            $likesRecibido->setLikesTo($this);
        }

        return $this;
    }

    public function removeLikesRecibido(Likes $likesRecibido): self
    {
        if ($this->likesRecibidos->removeElement($likesRecibido)) {
            // set the owning side to null (unless already changed)
            if ($likesRecibido->getLikesTo() === $this) {
                $likesRecibido->setLikesTo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Likes[]
     */
    public function getLikesDados(): Collection
    {
        return $this->likesDados;
    }

    public function addLikesDado(Likes $likesDado): self
    {
        if (!$this->likesDados->contains($likesDado)) {
            $this->likesDados[] = $likesDado;
            $likesDado->setLikesFrom($this);
        }

        return $this;
    }

    public function removeLikesDado(Likes $likesDado): self
    {
        if ($this->likesDados->removeElement($likesDado)) {
            // set the owning side to null (unless already changed)
            if ($likesDado->getLikesFrom() === $this) {
                $likesDado->setLikesFrom(null);
            }
        }

        return $this;
    }

    public function getHoraconexion(): ?\DateTimeInterface
    {
        return $this->horaconexion;
    }

    public function setHoraconexion(?\DateTimeInterface $horaconexion): self
    {
        $this->horaconexion = $horaconexion;

        return $this;
    }
}
