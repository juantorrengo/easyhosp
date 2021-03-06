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
    public function findDisponibilidad($from, $to){
        $dql = 'SELECT h, h.borrado, h.titulo, h.id, h.direccion, h.localidad, h.descripcion, h.capacidad, th.nombre as tipoHosp
                FROM MainBundle:Hospedaje h 
                INNER JOIN MainBundle:TipoHospedaje th WITH h.tipohospedaje = th.id
                WHERE h.id NOT IN (
                SELECT IDENTITY (r.hospedaje) FROM MainBundle:Reserva r 
                WHERE ((r.fechaInicio <= :desde AND r.fechaFin >= :desde) OR 
                      ( r.fechaInicio <= :hasta AND r.fechaFin >= :hasta) OR 
                      ( r.fechaInicio > :desde AND r.fechaFin < :hasta))
                )';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters(['desde'=>$from, 'hasta'=>$to])
            ->getResult();
    }

    public function findOneByReserva($idHospedaje){
        $dql = 'SELECT r FROM MainBundle:Reserva r WHERE r.hospedaje = :idHospedaje';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(':idHospedaje', $idHospedaje)
            ->getResult();
    }


    public function findMisReservas($userId){
        $dql = 'SELECT r, r.id, r.fechaInicio, r.fechaFin, IDENTITY (r.hospedaje), r.estado, h.titulo as titulo, 
                h.id as hospId, h.borrado as borrado 
                FROM MainBundle:Reserva r 
                INNER JOIN MainBundle:Hospedaje h WITH r.hospedaje = h.id
                WHERE (r.usuario = :userId AND r.fechaFin > CURRENT_DATE())';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(':userId', $userId)
            ->getResult();
    }

    public function findResFinalizadas($userId){
        $dql = 'SELECT r, r.id, r.fechaInicio, r.fechaFin, IDENTITY (r.hospedaje),r.estado, h.titulo as titulo, 
                h.id as hospId, h.borrado as borrado 
                FROM MainBundle:Reserva r 
                INNER JOIN MainBundle:Hospedaje h WITH r.hospedaje = h.id
                WHERE (r.usuario = :userId AND r.fechaFin < CURRENT_DATE())';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(':userId', $userId)
            ->getResult();
    }
    
    public function findResSinConf($userId){
    $dql = 'SELECT r, r.id, r.fechaInicio, r.fechaFin, IDENTITY (r.hospedaje),r.estado , h.titulo as titulo, 
                h.id as hospId, h.borrado as borrado
                FROM MainBundle:Reserva r 
                INNER JOIN MainBundle:Hospedaje h WITH r.hospedaje = h.id
                WHERE (h.usuario = :userId)';
    return $this->getEntityManager()
        ->createQuery($dql)
        ->setParameter(':userId', $userId)
        ->getResult();
    }

    public function findDatosCalificarRes($resId){
        $dql = 'SELECT r, r.id, r.fechaInicio, r.fechaFin, IDENTITY (r.hospedaje),r.estado , h.titulo as titulo, 
                h.id as hospId
                FROM MainBundle:Reserva r 
                INNER JOIN MainBundle:Hospedaje h WITH r.hospedaje = h.id
                WHERE (r.id = :resId)';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(':resId', $resId)
            ->getOneOrNullResult();
    }

    public function findDatosCalificarHuesp($resId){
        $dql = 'SELECT r, r.id, IDENTITY (r.hospedaje), h.titulo as titulo, 
                h.id as hospId, IDENTITY (r.usuario), u.id as userId, u.nombre as nombre, u.apellido as apellido
                FROM MainBundle:Reserva r 
                INNER JOIN MainBundle:Hospedaje h WITH r.hospedaje = h.id
                INNER JOIN MainBundle:Usuario u WITH r.usuario = u.id
                WHERE (r.id = :resId)';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(':resId', $resId)
            ->getOneOrNullResult();
    }

    public function findDetalleReserva($id){
        $dql = 'SELECT r, r.id, r.fechaInicio, r.fechaFin, IDENTITY (r.hospedaje), r.estado, h.titulo as titulo, 
                h.id as hospId, h.borrado as borrado 
                FROM MainBundle:Reserva r 
                INNER JOIN MainBundle:Hospedaje h WITH r.hospedaje = h.id
                WHERE r.usuario = :id';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(':id', $id)
            ->getOneOrNullResult();
    }

    public function findDatosReserva($id){
        $dql = 'SELECT r, r.id, r.fechaInicio, r.fechaFin, IDENTITY (r.hospedaje), r.estado, h.titulo as titulo, 
                h.id as hospId, IDENTITY (r.usuario), u.nombre as nombre, u.apellido as apellido, u.email as email,
                u.telefono as telefono
                FROM MainBundle:Reserva r 
                INNER JOIN MainBundle:Hospedaje h WITH r.hospedaje = h.id
                INNER JOIN MainBundle:Usuario u WITH r.usuario = u.id
                WHERE r.id = :id';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(':id', $id)
            ->getOneOrNullResult();
    }

}
