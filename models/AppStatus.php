<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AppStatus
 *
 * @ORM\Table(name="app_status")
 * @ORM\Entity
 */
class AppStatus
{
    const
        FIELD = 'status',
        RED = 1,
        YELLOW = 2,
        WHITE = 3,
        CYAN = 4,
        BLUE = 5,
        GREEN = 6,
        GRAY = 7;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="sort", type="integer", nullable=false)
     */
    private $sort;

    /**
     * @var string
     *
     * @ORM\Column(name="color_name", type="string", length=16, nullable=false)
     */
    private $colorName;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=6, nullable=false)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="style", type="string", length=16, nullable=false)
     */
    private $style;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=64, nullable=false)
     */
    private $picture;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @return string
     */
    public function getColorName(): string
    {
        return $this->colorName;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getStyle(): string
    {
        return $this->style;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }


}
