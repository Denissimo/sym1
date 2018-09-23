<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Region2offset
 *
 * @ORM\Table(name="region2offset")
 * @ORM\Entity
 */
class Region2offset
{
    /**
     * @var int
     *
     * @ORM\Column(name="region", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $region;

    /**
     * @var int|null
     *
     * @ORM\Column(name="offset", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $offset = '0';

    /**
     * @return int
     */
    public function getRegion(): int
    {
        return $this->region;
    }

    /**
     * @return int|null
     */
    public function getOffset()
    {
        return $this->offset;
    }


}
