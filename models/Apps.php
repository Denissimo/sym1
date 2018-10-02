<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Apps
 *
 * @ORM\Table(name="apps", indexes={@ORM\Index(name="createdAt", columns={"createdAt"}), @ORM\Index(name="IDX_101C7E5A9393F8FE", columns={"partner_id"}), @ORM\Index(name="in_work", columns={"in_work"}), @ORM\Index(name="status_index", columns={"status"}), @ORM\Index(name="trash", columns={"trash"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Apps
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
     * @var int|null
     *
     * @ORM\Column(name="foreign_id", type="integer", nullable=true)
     */
    private $foreignId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    private $createdat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=false)
     */
    private $updatedat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="trash", type="boolean", nullable=true)
     */
    private $trash = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="in_work", type="boolean", nullable=true)
     */
    private $inWork = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="ip", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $ip = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="check", type="string", length=255, nullable=true)
     */
    private $check;

    /**
     * @var \Partners
     *
     * @ORM\ManyToOne(targetEntity="Partners")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     * })
     */
    private $partner;

    /**
     * @var \Comments
     * @ORM\OneToMany(targetEntity="\Comments", mappedBy="app")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="app_id", nullable=false)
     * })
     */
    private $comments;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getForeignId()
    {
        return $this->foreignId;
    }

    /**
     * @return int|null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return DateTime
     */
    public function getCreatedat(): DateTime
    {
        return $this->createdat;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedat(): DateTime
    {
        return $this->updatedat;
    }

    /**
     * @return null|string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return bool|null
     */
    public function getTrash()
    {
        return $this->trash;
    }

    /**
     * @return bool|null
     */
    public function getInWork()
    {
        return $this->inWork;
    }

    /**
     * @return int
     */
    public function getIp(): int
    {
        return $this->ip;
    }

    /**
     * @return null|string
     */
    public function getCheck()
    {
        return $this->check;
    }

    /**
     * @return Partners
     */
    public function getPartner(): Partners
    {
        return $this->partner;
    }

    /**
     * @return Comments
     */
    public function getComments(): Comments
    {
        return $this->comments;
    }
}
