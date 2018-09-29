<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Passportcode2who
 *
 * @ORM\Table(name="passportcode2who")
 * @ORM\Entity
 */
class Passportcode2who
{
    /**
     * @var string
     *
     * @ORM\Column(name="pcode", type="string", length=6, nullable=false, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pcode = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="w", type="string", length=1000, nullable=true)
     */
    private $w = '';


}
