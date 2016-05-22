<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favorito
 *
 * @ORM\Table(name="favorito")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\Entity\FavoritosRepository")
 */
class Favorito
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
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="favoritos")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Hospedaje", inversedBy="favoritos")
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
     * Set usuario
     *
     * @param \MainBundle\Entity\Usuario $usuario
     *
     * @return Favorito
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
     * @return Favorito
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
}
