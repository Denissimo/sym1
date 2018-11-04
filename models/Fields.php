<?php



use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * Fields
 *
 * @ORM\Table(name="fields", indexes={@ORM\Index(name="IDX_7EE5E388FE54D947", columns={"group_id"}), @ORM\Index(name="name_index", columns={"name"})})
 * @ORM\Entity
 */
class Fields
{
    const
        FIRST_NAME = 5,
        LAST_NAME = 4,
        MIDDLE_NAME = 6,
        CITY = 39,
        PHONE = 8,
        CITY_MAX_LENGTH = 32
    ;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false, options={"comment"="0 = text, 1 = text+regex, 2 = list, 3 = FIAS"})
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var string|null
     *
     * @ORM\Column(name="regex", type="string", length=255, nullable=true)
     */
    private $regex;

    /**
     * @var bool
     *
     * @ORM\Column(name="required", type="boolean", nullable=false)
     */
    private $required;

    /**
     * @var int
     *
     * @ORM\Column(name="orderid", type="integer", nullable=false)
     */
    private $orderid = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="errortitle", type="string", length=255, nullable=true)
     */
    private $errortitle = '';

    /**
     * @var \FieldGroups
     *
     * @ORM\ManyToOne(targetEntity="FieldGroups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * })
     */
    private $group;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="\ValueLists", mappedBy="field")
     * @ORM\OrderBy({"id" = "ASC"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="field_id", nullable=false)
     * })
     */
    private $valueList;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return null|string
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @return int
     */
    public function getOrderid(): int
    {
        return $this->orderid;
    }

    /**
     * @return null|string
     */
    public function getErrortitle()
    {
        return $this->errortitle;
    }

    /**
     * @return FieldGroups
     */
    public function getGroup(): FieldGroups
    {
        return $this->group;
    }

    /**
     * @return Collection
     */
    public function getValueList(): Collection
    {
        return $this->valueList;
    }

}
