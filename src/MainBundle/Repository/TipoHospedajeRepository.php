<?php

namespace MainBundle\Repository;

/**
 * TipoHospedajeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TipoHospedajeRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllActives() {
        $dql = 'SELECT th FROM MainBundle:TipoHospedaje th WHERE th.borrado = 0 ORDER BY th.nombre';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();
    }

    public function findDeleteLogic($nombre) {
        $dql = 'SELECT th FROM BackendBundle:TipoHospedaje th WHERE (th.borrado = 1 AND th.nombre = :nombre)';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(':nombre', $nombre)
            ->getOneOrNullResult();
    }

    public function findHospedajesForTipo($id) {
        $dql = 'SELECT p.titulo FROM MainBundle:Hospedaje p WHERE p.tipohospedaje = :id';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(':id', $id)
            ->getOneOrNullResult();
    }
}
