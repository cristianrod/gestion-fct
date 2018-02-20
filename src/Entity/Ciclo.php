<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CicloRepository")
 */
class Ciclo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $codigo;

    /**
     * @ORM\Column(type="string")
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
     */
    private $grado;

    /**
     * @ORM\Column(type="integer")
     */
    private $horas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alumno", mappedBy="ciclo")
     */
    private $alumnos;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
    }
}
