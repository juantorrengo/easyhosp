<?php

namespace MainBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * HospedajeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HospedajeRepository extends \Doctrine\ORM\EntityRepository
{
    /*
	 * Función que devuelve todos los hospedajes paginados
	 */
    public function listarHospedajesPaginados($pageSize, $currentPage) {
        $em = $this->getEntityManager();
        $dql = 'SELECT h, h.titulo, h.id, h.direccion, h.localidad, h.fechaPublicacion, h.descripcion, h.capacidad, h.precio, th.nombre as tipoHosp 
                FROM MainBundle:Hospedaje h
                INNER JOIN MainBundle:TipoHospedaje th WITH h.tipohospedaje = th.id
                WHERE th.borrado = 0
                ORDER BY h.fechaPublicacion DESC';
        $query = $em->createQuery($dql)
            ->setFirstResult($pageSize * ($currentPage - 1))
            ->setMaxResults($pageSize);

        $paginator = new Paginator($query);

        return $paginator;
    }

    public function findDetalleHospedaje($id) {
        $dql = 'SELECT h, h.titulo, h.descripcion, h.fechaPublicacion, h.localidad, h.capacidad, h.precio, h.direccion, 
                th.nombre as tipoHosp, u.nombre as userNom, u.apellido as userApe
                FROM MainBundle:Hospedaje h 
                INNER JOIN MainBundle:TipoHospedaje th WITH h.tipohospedaje = th.id 
                INNER JOIN MainBundle:Usuario u WITH h.usuario = u.id 
                WHERE h.id = :id';
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(':id', $id)
            ->getOneOrNullResult();
    }

    public function buscarHospPaginated($busqueda, $pageSize, $currentPage) {
        $em = $this->getEntityManager();
        $dql = "SELECT h, h.id, h.titulo, h.localidad, h.direccion, h.precio, h.fechaPublicacion, h.capacidad, th.nombre as tipoHosp 
				FROM MainBundle:Hospedaje h
				INNER JOIN MainBundle:TipoHospedaje th WITH h.tipohospedaje = th.id
				WHERE (h.titulo LIKE :busqueda OR h.localidad LIKE :busqueda OR th.nombre LIKE :busqueda OR h.capacidad LIKE :busqueda OR h.capacidad LIKE :busqueda)
				ORDER BY h.fechaPublicacion DESC";
        $query = $em->createQuery($dql)
            ->setParameter('busqueda', '%'.$busqueda.'%')
            ->setFirstResult($pageSize * ($currentPage - 1))
            ->setMaxResults($pageSize);

        $paginator = new Paginator($query);

        return $paginator;
    }
}
