<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\UsuarioRepository")
 */
class Usuario
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=255)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var \Date
     *
     * @ORM\Column(name="fechaAlta", type="date")
     */
    private $fechaAlta;


    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=255, nullable=true)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="respuestaSeguridad", type="string", length=255, nullable=true)
     */
    private $respuestaSeguridad;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", length=1, nullable=true)
     */
    private $sexo;

    /**
     * @var integer
     *
     * @ORM\Column(name="preguntaSecreta", type="integer", length=1,  options={"default" = 0})
     */
    private $preguntaSecreta;


    /**
     * @var integer
     *
     * @ORM\Column(name="isPremium", type="integer", length=1,  options={"default" = 0})
     */
    private $isPremium;

    /**
     * @var integer
     *
     * @ORM\Column(name="isAdmin", type="integer", length=1,  options={"default" = 0})
     */
    private $isAdmin;

    /**
     * @ORM\OneToMany(targetEntity="Hospedaje", mappedBy="usuario")
     */
    protected $hospedajes;

    /**
     * @ORM\OneToMany(targetEntity="Calificacion", mappedBy="usuario")
     */
    protected $calificaciones;

    /**
     * @ORM\OneToMany(targetEntity="Consulta", mappedBy="usuario")
     */

    protected $consultas;

    /**
     * @ORM\OneToMany(targetEntity="Reserva", mappedBy="usuario")
     */
    protected $reservas;

    /**
     * @ORM\OneToMany(targetEntity="Favorito", mappedBy="usuario")
     */
    protected $favoritos;



    public function __construct()
    {
        $this->hospedajes = new ArrayCollection();
        $this->calificaciones = new ArrayCollection();
        $this->consultas = new ArrayCollection();
        $this->reservas = new ArrayCollection();
    }


    /**
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param string $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param string $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }


    /**
     * @return string
     */
    public function getRespuestaSeguridad()
    {
        return $this->respuestaSeguridad;
    }

    /**
     * @param string $respuestaSeguridad
     */
    public function setRespuestaSeguridad($respuestaSeguridad)
    {
        $this->respuestaSeguridad = $respuestaSeguridad;
    }

    /**
     * @return int
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param int $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return int
     */
    public function getIsPremium()
    {
        return $this->isPremium;
    }

    /**
     * @param int $isPremium
     */
    public function setIsPremium($isPremium)
    {
        $this->isPremium = $isPremium;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Usuario
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Usuario
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Usuario
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add hospedaje
     *
     * @param \MainBundle\Entity\Hospedaje $hospedaje
     *
     * @return Usuario
     */
    public function addHospedaje(\MainBundle\Entity\Hospedaje $hospedaje)
    {
        $this->hospedajes[] = $hospedaje;

        return $this;
    }

    /**
     * Remove hospedaje
     *
     * @param \MainBundle\Entity\Hospedaje $hospedaje
     */
    public function removeHospedaje(\MainBundle\Entity\Hospedaje $hospedaje)
    {
        $this->hospedajes->removeElement($hospedaje);
    }

    /**
     * Get hospedajes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHospedajes()
    {
        return $this->hospedajes;
    }

    /**
     * Add calificacione
     *
     * @param \MainBundle\Entity\Calificacion $calificacione
     *
     * @return Usuario
     */
    public function addCalificacione(\MainBundle\Entity\Calificacion $calificacione)
    {
        $this->calificaciones[] = $calificacione;

        return $this;
    }

    /**
     * Remove calificacione
     *
     * @param \MainBundle\Entity\Calificacion $calificacione
     */
    public function removeCalificacione(\MainBundle\Entity\Calificacion $calificacione)
    {
        $this->calificaciones->removeElement($calificacione);
    }

    /**
     * Get calificaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalificaciones()
    {
        return $this->calificaciones;
    }

    /**
     * Add consulta
     *
     * @param \MainBundle\Entity\Consulta $consulta
     *
     * @return Usuario
     */
    public function addConsulta(\MainBundle\Entity\Consulta $consulta)
    {
        $this->consultas[] = $consulta;

        return $this;
    }

    /**
     * Remove consulta
     *
     * @param \MainBundle\Entity\Consulta $consulta
     */
    public function removeConsulta(\MainBundle\Entity\Consulta $consulta)
    {
        $this->consultas->removeElement($consulta);
    }

    /**
     * Get consultas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConsultas()
    {
        return $this->consultas;
    }

    /**
     * Add reserva
     *
     * @param \MainBundle\Entity\Reserva $reserva
     *
     * @return Usuario
     */
    public function addReserva(\MainBundle\Entity\Reserva $reserva)
    {
        $this->reservas[] = $reserva;

        return $this;
    }

    /**
     * Remove reserva
     *
     * @param \MainBundle\Entity\Reserva $reserva
     */
    public function removeReserva(\MainBundle\Entity\Reserva $reserva)
    {
        $this->reservas->removeElement($reserva);
    }

    /**
     * Get reservas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservas()
    {
        return $this->reservas;
    }

    /**
     * Add favorito
     *
     * @param \MainBundle\Entity\Favorito $favorito
     *
     * @return Usuario
     */
    public function addFavorito(\MainBundle\Entity\Favorito $favorito)
    {
        $this->favoritos[] = $favorito;

        return $this;
    }

    /**
     * Remove favorito
     *
     * @param \MainBundle\Entity\Favorito $favorito
     */
    public function removeFavorito(\MainBundle\Entity\Favorito $favorito)
    {
        $this->favoritos->removeElement($favorito);
    }

    /**
     * Get favoritos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavoritos()
    {
        return $this->favoritos;
    }

    /**
     * @return int
     */
    public function getPreguntaSecreta()
    {
        return $this->preguntaSecreta;
    }

    /**
     * @param int $preguntaSecreta
     */
    public function setPreguntaSecreta($preguntaSecreta)
    {
        $this->preguntaSecreta = $preguntaSecreta;
    }

    /**
     * @return \Date
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * @param \Date $fechaAlta
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;
    }
}
