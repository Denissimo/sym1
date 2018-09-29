<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * RequestApi
 *
 * @ORM\Table(name="request_api")
 * @ORM\Entity
 */
class RequestApi
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
     * @var int
     *
     * @ORM\Column(name="decision", type="integer", nullable=false)
     */
    private $decision = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="pid", type="integer", nullable=false)
     */
    private $pid = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="partner", type="integer", nullable=false)
     */
    private $partner = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="create_ts", type="datetime", nullable=true)
     */
    private $createTs;

    /**
     * @var string|null
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="patronymic", type="string", length=255, nullable=true)
     */
    private $patronymic;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="sex", type="boolean", nullable=true)
     */
    private $sex;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mobile", type="string", length=45, nullable=true)
     */
    private $mobile;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="passport_id", type="string", length=45, nullable=true)
     */
    private $passportId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="residence", type="string", length=255, nullable=true)
     */
    private $residence;

    /**
     * @var string|null
     *
     * @ORM\Column(name="residence_fias", type="string", length=255, nullable=true)
     */
    private $residenceFias;

    /**
     * @var int|null
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var int|null
     *
     * @ORM\Column(name="term", type="integer", nullable=true)
     */
    private $term;


}
