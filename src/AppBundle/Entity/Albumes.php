<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * Albumes
 *
 * @ORM\Table(name="albumes")
 * @ORM\Entity
 */
class Albumes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=200, nullable=false)
     */
    private $titulo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_publicacion", type="date", nullable=false)
     */
    private $fechaPublicacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=false)
     */
    private $createAt;
    
    /**
     * @ORM\ManyToMany(targetEntity="Artistas", mappedBy="albumes")
     */
    private $artistas;

    public function __construct()
    {
        $this->createAt = new \DateTime();
        $this->artistas = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Albumes
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set fechaPublicacion
     *
     * @param \DateTime $fechaPublicacion
     * @return Albumes
     */
    public function setFechaPublicacion($fechaPublicacion)
    {
        $this->fechaPublicacion = $fechaPublicacion;

        return $this;
    }

    /**
     * Get fechaPublicacion
     *
     * @return \DateTime 
     */
    public function getFechaPublicacion()
    {
        return $this->fechaPublicacion;
    }

    /**
     * Get createAt
     *
     * @return \DateTime 
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }
    
    /**
     * 
     * @param \AppBundle\Entity\Artistas $artista
     */
    public function addArtista(Artistas $artista)
    {
        $artista->addAlbume($this);
        $this->artistas[] = $artista;
    }

    /**
     * Remove artistas
     *
     * @param \AppBundle\Entity\Artistas $artistas
     */
    public function removeArtista(\AppBundle\Entity\Artistas $artistas)
    {
        $this->artistas->removeElement($artistas);
    }

    /**
     * Get artistas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArtistas()
    {
        return $this->artistas;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return Albumes
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }
}
