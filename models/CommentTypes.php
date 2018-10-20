<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CommentTypes
 *
 * @ORM\Table(name="comment_types", indexes={@ORM\Index(name="appstatus", columns={"app_status"})})
 * @ORM\Entity
 */
class CommentTypes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
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
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=false)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="date_interval", type="string", length=8, nullable=false)
     */
    private $dateInterval;

    /**
     * @var bool
     *
     * @ORM\Column(name="in_work", type="boolean", nullable=false)
     */
    private $inWork;

    /**
     * @var \AppStatus
     *
     * @ORM\ManyToOne(targetEntity="AppStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="app_status", referencedColumnName="id")
     * })
     */
    private $appStatus;

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
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getDateInterval(): string
    {
        return $this->dateInterval;
    }

    /**
     * @return bool
     */
    public function isInWork(): bool
    {
        return $this->inWork;
    }

    /**
     * @return AppStatus
     */
    public function getAppStatus(): AppStatus
    {
        return $this->appStatus;
    }


}
