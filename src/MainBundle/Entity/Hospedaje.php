<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Hospedaje
 *
 * @ORM\Table(name="hospedaje")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\HospedajeRepository")
 */
class Hospedaje
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
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var \Date
     *
     * @ORM\Column(name="fechaPublicacion", type="date")
     */
    private $fechaPublicacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="borrado", type="integer", length=1,  options={"default" = 0})
     */
    private $borrado;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;


    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=255)
     */
    private $localidad;

    /**
     * @var int
     *
     * @ORM\Column(name="precio", type="integer")
     */
    private $precio;

    /**
     * @var string
     *
     * @ORM\Column(name="capacidad", type="string", length=255)
     */
    private $capacidad;

    /**
     * @ORM\ManyToOne(targetEntity="TipoHospedaje", inversedBy="hospedajes")
     * @ORM\JoinColumn(name="tipohospedaje_id", referencedColumnName="id")
     */
    protected $tipohospedaje;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="hospedajes")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    protected $usuario;

    /**
     * @ORM\OneToMany(targetEntity="Calificacion", mappedBy="hospedaje")
     */
    protected $calificaciones;

    /**
     * @ORM\OneToMany(targetEntity="Consulta", mappedBy="hospedaje")
     */
    protected $consultas;

    /**
     * @ORM\OneToMany(targetEntity="Reserva", mappedBy="hospedaje")
     */
    protected $reservas;

    /**
     * @ORM\OneToMany(targetEntity="Favorito", mappedBy="hospedaje")
     */
    protected $favoritos;


    public function __construct()
    {
        $this->calificaciones = new ArrayCollection();
        $this->consultas = new ArrayCollection();
        $this->reservas = new ArrayCollection();
        $this->favoritos = new ArrayCollection();
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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Hospedaje
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Hospedaje
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaPublicacion
     *
     * @param \Date $fechaPublicacion
     *
     * @return Hospedaje
     */
    public function setFechaPublicacion($fechaPublicacion)
    {
        $this->fechaPublicacion = $fechaPublicacion;

        return $this;
    }

    /**
     * Get fechaPublicacion
     *
     * @return \Date
     */
    public function getFechaPublicacion()
    {
        return $this->fechaPublicacion;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Hospedaje
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
     * Set precio
     *
     * @param integer $precio
     *
     * @return Hospedaje
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return int
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set capacidad
     *
     * @param string $capacidad
     *
     * @return Hospedaje
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad
     *
     * @return string
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set tipohospedaje
     *
     * @param \MainBundle\Entity\TipoHospedaje $tipohospedaje
     *
     * @return Hospedaje
     */
    public function setTipohospedaje(\MainBundle\Entity\TipoHospedaje $tipohospedaje = null)
    {
        $this->tipohospedaje = $tipohospedaje;

        return $this;
    }

    /**
     * Get tipohospedaje
     *
     * @return \MainBundle\Entity\TipoHospedaje
     */
    public function getTipohospedaje()
    {
        return $this->tipohospedaje;
    }

    /**
     * Set usuario
     *
     * @param \MainBundle\Entity\Usuario $usuario
     *
     * @return Hospedaje
     */
    public function setUsuario(\MainBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \MainBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Add calificacione
     *
     * @param \MainBundle\Entity\Calificacion $calificacione
     *
     * @return Hospedaje
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
     * @return Hospedaje
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
     * @return Hospedaje
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
     * @return Hospedaje
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
     * @return string
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * @param string $localidad
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
    }

    /**
     * @return int
     */
    public function getBorrado()
    {
        return $this->borrado;
    }

    /**
     * @param int $borrado
     */
    public function setBorrado($borrado)
    {
        $this->borrado = $borrado;
    }

}
