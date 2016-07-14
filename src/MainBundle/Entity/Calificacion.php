<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calificacion
 *
 * @ORM\Table(name="calificacion")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\CalificacionRepository")
 */
class Calificacion
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
     * @var int
     *
     * @ORM\Column(name="puntaje", type="integer")
     */
    private $puntaje;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="calificaciones")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=true)
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Hospedaje", inversedBy="calificaciones")
     * @ORM\JoinColumn(name="hospedaje_id", referencedColumnName="id", nullable=true)
     */
    protected $hospedaje;

    /**
     * @var int
     *
     * @ORM\Column(name="reserva", type="integer", length=1)
     */
    private $reserva;


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
     * Set usuario
     *
     * @param \MainBundle\Entity\Usuario $usuario
     *
     * @return Calificacion
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
     * @return Calificacion
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
     * @return int
     */
    public function getReserva()
    {
        return $this->reserva;
    }

    /**
     * @param int $reserva
     */
    public function setReserva($reserva)
    {
        $this->reserva = $reserva;
    }

    /**
     * @return int
     */
    public function getPuntaje()
    {
        return $this->puntaje;
    }

    /**
     * @param int $puntaje
     */
    public function setPuntaje($puntaje)
    {
        $this->puntaje = $puntaje;
    }
}
