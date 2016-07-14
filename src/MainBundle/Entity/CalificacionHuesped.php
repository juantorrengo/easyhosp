<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CalificacionHuesped
 *
 * @ORM\Table(name="calificacion_huesped")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\CalificacionHuespedRepository")
 */
class CalificacionHuesped
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
     * @var int
     *
     * @ORM\Column(name="usercalificado", type="integer", length=1)
     */
    private $usercalificado;

    /**
     * @var int
     *
     * @ORM\Column(name="usercalificador", type="integer", length=1)
     */
    private $usercalificador;


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
     * Set puntaje
     *
     * @param integer $puntaje
     *
     * @return CalificacionHuesped
     */
    public function setPuntaje($puntaje)
    {
        $this->puntaje = $puntaje;

        return $this;
    }

    /**
     * @return int
     */
    public function getUsercalificado()
    {
        return $this->usercalificado;
    }

    /**
     * Get puntaje
     *
     * @return int
     */
    public function getPuntaje()
    {
        return $this->puntaje;
    }

    /**
     * @param int $usercalificado
     */
    public function setUsercalificado($usercalificado)
    {
        $this->usercalificado = $usercalificado;
    }

    /**
     * @return int
     */
    public function getUsercalificador()
    {
        return $this->usercalificador;
    }

    /**
     * @param int $usercalificador
     */
    public function setUsercalificador($usercalificador)
    {
        $this->usercalificador = $usercalificador;
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
}

