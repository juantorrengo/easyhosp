<?php

namespace MainBundle\Repository;

/**
 * ReservaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReservaRepository extends \Doctrine\ORM\EntityRepository
{
    public function findDisponibilidad($from, $to, $id){
        $dql = 'SELECT r, r.id, r.fechaFin, r.fechaInicio FROM MainBundle:Reserva r 
                WHERE ((r.fechaInicio <= :desde AND r.fechaFin >= :desde AND r.hospedaje = :id) OR 
                      ( r.fechaInicio <= :hasta AND r.fechaFin >= :hasta AND r.hospedaje = :id) OR 
                      ( r.fechaInicio > :desde AND r.fechaFin < :hasta AND r.hospedaje = :id))';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters(['desde'=>$from, 'hasta'=>$to, 'id'=>$id])
            ->getOneOrNullResult();
    }

    public function findOneByReserva($idHospedaje){
        $dql = 'SELECT r FROM MainBundle:Reserva r WHERE r.hospedaje = :idHospedaje';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(':idHospedaje', $idHospedaje)
            ->getResult();
    }


}
