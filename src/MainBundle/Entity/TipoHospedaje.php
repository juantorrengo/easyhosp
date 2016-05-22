<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TipoHospedaje
 *
 * @ORM\Table(name="tipo_hospedaje")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\Entity\TipoHospedajeRepository")
 */
class TipoHospedaje
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
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Hospedaje", mappedBy="tipohospedaje")
     */
    protected $hospedajes;

    public function __construct()
    {
        $this->hospedajes = new ArrayCollection();
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
     * @return TipoHospedaje
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
     * Add hospedaje
     *
     * @param \MainBundle\Entity\Hospedaje $hospedaje
     *
     * @return TipoHospedaje
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
}
