<?php


use Doctrine\ORM\Mapping as ORM;

/**
 * Options
 *
 * @ORM\Table(name="options")
 * @ORM\Entity
 */
class Options
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
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=64, nullable=false)
     */
    private $value;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Options
     */
    public function setId(int $id): Options
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Options
     */
    public function setName(string $name): Options
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return Options
     */
    public function setValue(string $value): Options
    {
        $this->value = $value;
        return $this;
    }
}
