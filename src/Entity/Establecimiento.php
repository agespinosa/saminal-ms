<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\EstablecimientoRepository;

/**
 * @ApiResource(
 *     collectionOperations={
 *     "get",
 *     "post"
 *     },
 *     itemOperations={
 *         "get"={
 *             "normalization_context"={"groups"={"establecimiento:read","establecimiento:item:get"}}
 *         },
 *         "put",
 *     },
 *     normalizationContext={"groups"={"establecimiento:read"}, "swagger_definition_name"= "Read"},
 *     denormalizationContext={"groups"={"establecimiento:write"}, "swagger_definition_name"= "Write"},
 *     shortName="establecimiento",
 *     attributes={
 *          "pagination_items_per_page"=10,
 *          "formats"={"jsonld", "json", "html", "jsonhal", "csv"={"text/csv"}}
 *     }
 * )
 * @ORM\Entity(repositoryClass=EstablecimientoRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"isActive"})
 * @ApiFilter(SearchFilter::class,
 *     properties={
 *     "nombre":"partial",
 *     "propietario"="exact",
 *     "propietario.razonSocial"="partial"
 *      })
 * @ApiFilter(PropertyFilter::class)
 */
class Establecimiento
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"establecimiento:read","establecimiento:write","propietario:read", "propietario:write","propietario:item:get"})
     * @Assert\NotBlank(
     *     message="El nombre del establecimiento es requerido"
     * )
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"establecimiento:read","establecimiento:write", "propietario:read", "propietario:write"})
     */
    private $cantidadHectareas;

    /**
     * @ORM\ManyToOne(targetEntity=Propietario::class, inversedBy="establecimientos")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"establecimiento:read","establecimiento:write"})
     * @ApiSubresource()
     */
    private $propietario;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"establecimiento:read","establecimiento:write","propietario:read", "propietario:write"})
     */
    private $isActive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCantidadHectareas(): ?int
    {
        return $this->cantidadHectareas;
    }

    public function setCantidadHectareas(int $cantidadHectareas): self
    {
        $this->cantidadHectareas = $cantidadHectareas;

        return $this;
    }

    public function getPropietario(): ?Propietario
    {
        return $this->propietario;
    }

    public function setPropietario(?Propietario $propietario): self
    {
        $this->propietario = $propietario;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
