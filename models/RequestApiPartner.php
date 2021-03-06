<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * RequestApiPartner
 *
 * @ORM\Table(name="request_api_partner")
 * @ORM\Entity
 */
class RequestApiPartner
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
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="key", type="string", length=255, nullable=true)
     */
    private $key;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_enabled", type="boolean", nullable=true)
     */
    private $isEnabled = '0';


}
