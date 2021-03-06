<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlumnoRepository")
 * @ORM\Table(name="alumnos")
 * @UniqueEntity("nif")
 * @Vich\Uploadable
 */
class Alumno
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\Regex(
     *     pattern="/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i",
     *     message="valid.nif"
     * )
     * @Assert\NotBlank()
     */
    private $nif;

    /**
     * @Assert\Regex(
     *     pattern="/[0-9]/",
     *     match=false
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=50)
     */
    private $nombre;

    /**
     * @Assert\Regex(
     *     pattern="/[0-9]/",
     *     match=false
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=50)
     */
    private $apellido1;

    /**
     * * @Assert\Regex(
     *     pattern="/[0-9]/",
     *     match=false
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=50)
     */
    private $apellido2;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $fotografia;

    /**
     * @Vich\UploadableField(mapping="alumnos_foto", fileNameProperty="fotografia")
     * @Assert\Image()
     */
    private $fichero;

    /**
     * @return mixed
     */
    public function getFichero(): ?File
    {
        return $this->fichero;
    }

    /**
     * @param null $foto
     */
    public function setFichero($foto = null): void
    {
        $this->fichero = $foto;
        if (null !== $foto) {
            $this->fechaSubida = new \DateTimeImmutable();
        }
    }

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fechaSubida;

    /**
     * @ORM\Column(type="string", nullable=true, length=100)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $poblacion;

    /**
     * @Assert\Regex(
     *     pattern="/(0[1-9]|5[0-2]|[0-4][0-9])[0-9]{3}/i",
     *     message="valid.cpostal"
     * )
     * @Assert\Length(
     *     max="5",
     *     min="5"
     * )
     * @ORM\Column(type="string", nullable=true)
     */
    private $codpostal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Provincia", inversedBy="alumnos")
     */
    private $provincia;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^(\+34|0034|34)?[6|7][0-9]{8}$/",
     *     message="valid.movil"
     * )
     */
    private $movil;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Regex(
     *     pattern="/^(\+34|0034|34)?[9][0-9]{8}$/",
     *     message="valid.fijo"
     * )
     */
    private $fijo;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Email(
     *     message="valid.correo"
     * )
     * @Assert\NotBlank()
     */
    private $correo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ciclo", inversedBy="alumnos")
     */
    private $ciclo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fct", mappedBy="alumno", cascade={"persist", "remove"})
     */
    private $fcts;

    public function __construct()
    {
        $this->fcts = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNif()
    {
        return $this->nif;
    }

    /**
     * @param mixed $nif
     */
    public function setNif($nif): void
    {
        $this->nif = $nif;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getApellido1()
    {
        return $this->apellido1;
    }

    /**
     * @param mixed $apellido1
     */
    public function setApellido1($apellido1): void
    {
        $this->apellido1 = $apellido1;
    }

    /**
     * @return mixed
     */
    public function getApellido2()
    {
        return $this->apellido2;
    }

    /**
     * @param mixed $apellido2
     */
    public function setApellido2($apellido2): void
    {
        $this->apellido2 = $apellido2;
    }

    /**
     * @return mixed
     */
    public function getFotografia()
    {
        return $this->fotografia;
    }

    /**
     * @param mixed $fotografia
     */
    public function setFotografia($fotografia): void
    {
        $this->fotografia = $fotografia;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getPoblacion()
    {
        return $this->poblacion;
    }

    /**
     * @param mixed $poblacion
     */
    public function setPoblacion($poblacion): void
    {
        $this->poblacion = $poblacion;
    }

    /**
     * @return mixed
     */
    public function getCodpostal()
    {
        return $this->codpostal;
    }

    /**
     * @param mixed $codpostal
     */
    public function setCodpostal($codpostal): void
    {
        $this->codpostal = $codpostal;
    }

    /**
     * @return mixed
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * @param mixed $provincia
     */
    public function setProvincia($provincia): void
    {
        $this->provincia = $provincia;
    }

    /**
     * @return mixed
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     * @param mixed $movil
     */
    public function setMovil($movil): void
    {
        $this->movil = $movil;
    }

    /**
     * @return mixed
     */
    public function getFijo()
    {
        return $this->fijo;
    }

    /**
     * @param mixed $fijo
     */
    public function setFijo($fijo): void
    {
        $this->fijo = $fijo;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getCiclo()
    {
        return $this->ciclo;
    }

    /**
     * @param mixed $ciclo
     */
    public function setCiclo($ciclo): void
    {
        $this->ciclo = $ciclo;
    }

    /**
     * @return mixed
     */
    public function getFcts()
    {
        return $this->fcts;
    }

    public function addFct(Fct $fct)
    {
        if ($this->fcts->contains($fct)){
            return;
        }
        $this->fcts[] = $fct;
        $fct->setAlumno($this);
    }

    public function removeFct(Fct $fct)
    {
        $this->fcts->removeElement($fct);
        $fct->setAlumno(null);
    }
}
