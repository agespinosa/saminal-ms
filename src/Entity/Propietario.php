<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;

use App\Repository\PropietarioRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 *     collectionOperations={
 *     "get",
 *     "post"
 *     },
 *     itemOperations={
 *                  "get",
 *                  "put"
 *      },
 *     normalizationContext={"groups"={"propietario:read"}, "swagger_definition_name"= "Read"},
 *     denormalizationContext={"groups"={"propietario:write"}, "swagger_definition_name"= "Write"},
 *     shortName="propietario",
 *     attributes={
 *          "pagination_items_per_page"=10,
 *          "formats"={"jsonld", "json", "html", "jsonhal", "csv"={"text/csv"}}
 *     }
 * )
 * @ORM\Entity(repositoryClass=PropietarioRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"isActive"})
 * @ApiFilter(SearchFilter::class, properties={"cuit":"partial", "razonSocial"="partial"})
 * @ApiFilter(RangeFilter::class, properties={"codigoPostal"})
 * @ApiFilter(PropertyFilter::class)
 */
class Propietario
{
    use TimestampableEntity;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"propietario:read","propietario:write"})
     */
   private $renspa;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"propietario:read","propietario:write"})
     * @Assert\NotBlank(
     * message="La razon Social es obligatoria"
     * )
     */
    private $razonSocial;

    
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Groups({"propietario:read","propietario:write"})
     */
    private $cuit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Slug(fields={"cuit"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"propietario:read"})
     */
    private $domicilio;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"propietario:read","propietario:write"})
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"propietario:read", "propietario:write"})
     */
    private $condicion;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"propietario:read","propietario:write"})
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="3",
     *     max="4",
     *     maxMessage="El codigo postal debe tener entre 3 y 4 digitos"
     * )
     */
    private $codigoPostal;



    public function __construct(string $condicion= 'Propietaro')
    {
        $this->condicion = $condicion;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRenspa(): ?string
    {
        return $this->renspa;
    }

    public function setRenspa(string $renspa): self
    {
        $this->renspa = $renspa;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * @param mixed $razonSocial
     */
    public function setRazonSocial($razonSocial): void
    {
        $this->razonSocial = $razonSocial;
    }


    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * @param mixed $cuit
     */
    public function setCuit($cuit): void
    {
        $this->cuit = $cuit;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    public function getDomicilio(): ?string
    {
        return $this->domicilio;
    }

    /**
     * @Groups({"propietario:write"})
     * @SerializedName("lugar")
     */
    public function setDomicilioPersonalizado(?string $domicilio): self
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    public function setDomicilio(?string $domicilio): self
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * @Groups({"propietario:read"})
     */
    public function getCuitPersonalizado(): string
    {
      return $this->cuit;
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

    /**
     * @return string
     */
    public function getCondicion(): string
    {
        return $this->condicion;
    }

    public function getCodigoPostal(): ?int
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(int $codigoPostal): self
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * @Groups({"propietario:read"})
     */
    public function getShortRazonSocial(): ?string
    {
        if(strlen($this->razonSocial)<40){
            return $this->razonSocial;
        }
        return substr($this->razonSocial, 0, 40). '...';
    }

}
