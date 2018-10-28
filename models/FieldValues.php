<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * FieldValues
 *
 * @ORM\Table(name="field_values", indexes={@ORM\Index(name="app_field", columns={"app_id", "field_id"}), @ORM\Index(name="app_index", columns={"app_id"}), @ORM\Index(name="field_index", columns={"field_id"}), @ORM\Index(name="value_item_index", columns={"value_item_id"})})
 * @ORM\Entity
 */
class FieldValues
{
    const
        ID = 'id',
        APP_ID = 'app_id',
        READY = 'ready',
        FIELD = 'field'
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
     * @var string|null
     *
     * @ORM\Column(name="value_text", type="string", length=255, nullable=true)
     */
    private $valueText;

    /**
     * @var string|null
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * @var \Fields
     *
     * @ORM\ManyToOne(targetEntity="Fields")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="field_id", referencedColumnName="id")
     * })
     */
    private $field;

    /**
     * @var \Apps
     *
     * @ORM\ManyToOne(targetEntity="Apps")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="app_id", referencedColumnName="id")
     * })
     */
    private $app;

    /**
     * @var \ValueLists
     *
     * @ORM\ManyToOne(targetEntity="ValueLists")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="value_item_id", referencedColumnName="id")
     * })
     */
    private $valueItem;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getValueText()
    {
        return $this->valueText;
    }

    /**
     * @return null|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return Fields
     */
    public function getField(): Fields
    {
        return $this->field;
    }

    /**
     * @return Apps
     */
    public function getApp(): Apps
    {
        return $this->app;
    }

    /**
     * @return ValueLists
     */
    public function getValueItem(): ValueLists
    {
        return $this->valueItem;
    }

    /**
     * @param int $id
     * @return FieldValues
     */
    public function setId(int $id): FieldValues
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param null|string $valueText
     * @return FieldValues
     */
    public function setValueText($valueText)
    {
        $this->valueText = $valueText;
        return $this;
    }

    /**
     * @param null|string $value
     * @return FieldValues
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param Fields $field
     * @return FieldValues
     */
    public function setField(Fields $field): FieldValues
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @param Apps $app
     * @return FieldValues
     */
    public function setApp(Apps $app): FieldValues
    {
        $this->app = $app;
        return $this;
    }

    /**
     * @param ValueLists $valueItem
     * @return FieldValues
     */
    public function setValueItem(ValueLists $valueItem): FieldValues
    {
        $this->valueItem = $valueItem;
        return $this;
    }
}
