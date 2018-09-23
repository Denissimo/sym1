<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Ip2reg
 *
 * @ORM\Table(name="ip2reg")
 * @ORM\Entity
 */
class Ip2reg
{
    /**
     * @var int
     *
     * @ORM\Column(name="ip1", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ip1 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="ip2", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ip2 = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="reg", type="string", length=1000, nullable=true)
     */
    private $reg = '';

    /**
     * @return int
     */
    public function getIp1(): int
    {
        return $this->ip1;
    }

    /**
     * @return int
     */
    public function getIp2(): int
    {
        return $this->ip2;
    }

    /**
     * @return null|string
     */
    public function getReg()
    {
        return $this->reg;
    }


}
