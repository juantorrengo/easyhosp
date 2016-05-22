<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provincia
 *
 * @ORM\Table(name="provincia")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\Entity\ProvinciaRepository")
 */
class Provincia
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
     * @ORM\OneToMany(targetEntity="Localidad", mappedBy="provincia")
     */
    protected $localidades;

    public function __construct()
    {
        $this->localidades = new ArrayCollection();
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
     * @return Provincia
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
     * Add localidade
     *
     * @param \MainBundle\Entity\Localidad $localidade
     *
     * @return Provincia
     */
    public function addLocalidade(\MainBundle\Entity\Localidad $localidade)
    {
        $this->localidades[] = $localidade;

        return $this;
    }

    /**
     * Remove localidade
     *
     * @param \MainBundle\Entity\Localidad $localidade
     */
    public function removeLocalidade(\MainBundle\Entity\Localidad $localidade)
    {
        $this->localidades->removeElement($localidade);
    }

    /**
     * Get localidades
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocalidades()
    {
        return $this->localidades;
    }
}
