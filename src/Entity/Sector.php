<?php

namespace App\Entity;

use App\Repository\SectorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @ORM\Table(name="Sector")
 * @ORM\Entity(repositoryClass=SectorRepository::class)
 */

class Sector
{
 

/**
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  * @ORM\Column(type="integer")
  * 
  * 
  */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * 
     */
    private $Nombre;
    
public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }
}