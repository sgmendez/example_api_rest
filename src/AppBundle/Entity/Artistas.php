<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * Artistas
 *
 * @ORM\Table(name="artistas")
 * @ORM\Entity
 */
class Artistas
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
     * @ORM\Column(name="nombre", type="string", length=200, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="rol", type="string", length=50, nullable=false)
     */
    private $rol;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=false)
     */
    private $createAt;

    /**
     * @var type 
     * 
     * @ORM\ManyToMany(targetEntity="Albumes", inversedBy="artistas")
     * @ORM\JoinTable(name="artistas_albumes")
     */
    private $albumes;
    
    public function __construct()
    {
        $this->createAt = new \DateTime();
        $this->albumes = new ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Artistas
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
     * Set rol
     *
     * @param string $rol
     * @return Artistas
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string 
     */
    public function getRol()
    {
        return $this->rol;
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
     * Add albumes
     *
     * @param \AppBundle\Entity\Albumes $albumes
     * @return Artistas
     */
    public function addAlbume(\AppBundle\Entity\Albumes $albumes)
    {
        $this->albumes[] = $albumes;

        return $this;
    }

    /**
     * Remove albumes
     *
     * @param \AppBundle\Entity\Albumes $albumes
     */
    public function removeAlbume(\AppBundle\Entity\Albumes $albumes)
    {
        $this->albumes->removeElement($albumes);
    }

    /**
     * Get albumes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlbumes()
    {
        return $this->albumes;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return Artistas
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }
}
