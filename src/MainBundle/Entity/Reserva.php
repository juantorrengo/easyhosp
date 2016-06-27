<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reserva
 *
 * @ORM\Table(name="reserva")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ReservaRepository")
 */
class Reserva
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
     * @var \Date
     *
     * @ORM\Column(name="fechaInicio", type="date")
     */
    private $fechaInicio;


    /**
     * @var \Date
     *
     * @ORM\Column(name="fechaFin", type="date")
     */
    private $fechaFin;

    /**
     * @var int
     *
     * @ORM\Column(name="monto", type="integer")
     */
    private $monto;

    /**
     * @var integer
     *
     * @ORM\Column(name="confirmada", type="integer", length=1,  options={"default" = 0})
     */
    private $confirmada;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="reservas")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Hospedaje", inversedBy="reservas")
     * @ORM\JoinColumn(name="hospedaje_id", referencedColumnName="id")
     */
    protected $hospedaje;


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
     * Set monto
     *
     * @param integer $monto
     *
     * @return Reserva
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return int
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set usuario
     *
     * @param \MainBundle\Entity\Usuario $usuario
     *
     * @return Reserva
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
     * Set hospedaje
     *
     * @param \MainBundle\Entity\Hospedaje $hospedaje
     *
     * @return Reserva
     */
    public function setHospedaje(\MainBundle\Entity\Hospedaje $hospedaje = null)
    {
        $this->hospedaje = $hospedaje;

        return $this;
    }

    /**
     * Get hospedaje
     *
     * @return \MainBundle\Entity\Hospedaje
     */
    public function getHospedaje()
    {
        return $this->hospedaje;
    }

    /**
     * @return \Date
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * @param \Date $fechaInicio
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    /**
     * @return \Date
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * @param \Date $fechaFin
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;
    }

    /**
     * @return mixed
     */
    public function getConfirmada()
    {
        return $this->confirmada;
    }

    /**
     * @param mixed $confirmada
     */
    public function setConfirmada($confirmada)
    {
        $this->confirmada = $confirmada;
    }
}
