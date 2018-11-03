<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * FieldGroups
 *
 * @ORM\Table(name="field_groups")
 * @ORM\Entity
 */
class FieldGroups
{
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="orderNum", type="integer", nullable=false)
     */
    private $ordernum;

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
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getOrdernum(): int
    {
        return $this->ordernum;
    }

}
