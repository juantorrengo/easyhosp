<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Localidad
 *
 * @ORM\Table(name="localidad")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\LocalidadRepository")
 */
class Localidad
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
     * @ORM\OneToMany(targetEntity="Hospedaje", mappedBy="localidad")
     */
    protected $hospedajes;

    /**
     * @ORM\ManyToOne(targetEntity="Provincia", inversedBy="localidades")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id")
     */
    protected $provincia;

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
     * @return Localidad
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
     * @return Localidad
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
     * Set provincia
     *
     * @param \MainBundle\Entity\Provincia $provincia
     *
     * @return Localidad
     */
    public function setProvincia(\MainBundle\Entity\Provincia $provincia = null)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return \MainBundle\Entity\Provincia
     */
    public function getProvincia()
    {
        return $this->provincia;
    }
}
