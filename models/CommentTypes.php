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
     * @return AppStatus
     */
    public function getAppStatus(): AppStatus
    {
        return $this->appStatus;
    }


}
