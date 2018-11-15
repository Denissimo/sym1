<?php


use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Apps
 *
 * @ORM\Table(name="apps", indexes={@ORM\Index(name="createdAt", columns={"createdAt"}), @ORM\Index(name="IDX_101C7E5A9393F8FE", columns={"partner_id"}), @ORM\Index(name="in_work", columns={"in_work"}), @ORM\Index(name="status_index", columns={"status"}), @ORM\Index(name="trash", columns={"trash"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Apps
{
    const
        ID = 'id',
        STATUS = 'status',
        UPDATED = 'updatedat',
        USER_ID = 'user_id'
    ;

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
     * @var \AppStatus
     *
     * @ORM\ManyToOne(targetEntity="AppStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status", referencedColumnName="id")
     * })
     */
    private $appStatus;

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
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="\Comments", mappedBy="app")
     * @ORM\OrderBy({"id" = "DESC"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="app_id", nullable=false)
     * })
     */
    private $comments;

    /**
     * @var Comments
     * @ORM\OneToMany(targetEntity="Comments", mappedBy="app")
     * @ORM\OrderBy({"id" = "DESC"})
     * @ORM\JoinColumn(name="id", referencedColumnName="app_id")
     */
    private $lastComment;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="FieldValues", mappedBy="app")
     * @ORM\OrderBy({"id" = "DESC"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="app_id")
     * })
     */
    private $fieldValues;


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
        return (new \DateTime()) < $this->updatedat ? \AppStatus::CYAN : $this->status;
//        return $this->status;
    }

    /**
     * @return AppStatus
     */
    public function getAppStatus(): AppStatus
    {
        return $this->appStatus;
    }

    /**
     * @return DateTime
     */
    public function getCreatedat(): DateTime
    {
        return $this->createdat;
    }

    /**
     * @return string
     */
    public function getCreatedatString(): string
    {
        return $this->createdat->format('d.m.Y H:i');
    }

    /**
     * @return string
     */
    public function getUpdatedatString(): string
    {
        return $this->updatedat->format('d.m.Y H:i');
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
     * @return Users
     */
    public function getUser(): Users
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->user->getNameShort();
    }

    /**
     * @return Collection
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @return Comments
     */
    public function getLastComment() : Comments
    {
        return $this->comments->first();
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param $foreignId
     * @return $this
     */
    public function setForeignId($foreignId)
    {
        $this->foreignId = $foreignId;
        return $this;
    }

    /**
     * @param $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param AppStatus $appStatus
     * @return $this
     */
    public function setAppStatus(AppStatus $appStatus)
    {
        $this->appStatus = $appStatus;
        return $this;
    }


    /**
     * @param DateTime $createdat
     * @return $this
     */
    public function setCreatedat(DateTime $createdat)
    {
        $this->createdat = $createdat;
        return $this;
    }

    /**
     * @param DateTime $updatedat
     * @return $this
     */
    public function setUpdatedat(DateTime $updatedat)
    {
        $this->updatedat = $updatedat;
        return $this;
    }

    /**
     * @param $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @param $trash
     * @return $this
     */
    public function setTrash($trash)
    {
        $this->trash = $trash;
        return $this;
    }

    /**
     * @param $inWork
     * @return $this
     */
    public function setInWork($inWork)
    {
        $this->inWork = $inWork;
        return $this;
    }

    /**
     * @param int $ip
     * @return $this
     */
    public function setIp(int $ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @param $check
     * @return $this
     */
    public function setCheck($check)
    {
        $this->check = $check;
        return $this;
    }

    /**
     * @param Partners $partner
     * @return $this
     */
    public function setPartner(Partners $partner)
    {
        $this->partner = $partner;
        return $this;
    }

    /**
     * @param Users $user
     * @return $this
     */
    public function setUser(Users $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param Collection $comments
     * @return $this
     */
    public function setComments(Collection $comments)
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @param Comments $lastComment
     * @return $this
     */
    public function setLastComment(Comments $lastComment)
    {
        $this->lastComment = $lastComment;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getFieldValues(): Collection
    {
        return $this->fieldValues;
    }

   /**
   * @return string | null
   */
   private function getFieldValue(int $id)
    {
        foreach ($this->fieldValues as $val)
        {
            if($val->getField()->getId() == $id) {
                return $val->getValueText();
            }
        }
        return null;
    }

    /**
     * @return string | null
     */
    public function getFirstName()
    {
        return $this->getFieldValue(\Fields::FIRST_NAME);
    }

    /**
     * @return string | null
     */
    public function getLastName()
    {
        return $this->getFieldValue(\Fields::LAST_NAME);
    }

    /**
     * @return string | null
     */
    public function getMiddleName()
    {
        return $this->getFieldValue(\Fields::MIDDLE_NAME);
    }

    /**
     * @return string | null
     */
    public function getCity()
    {
        return mb_substr($this->getFieldValue(\Fields::CITY), 0, \Fields::CITY_MAX_LENGTH);
    }

    /**
     * @return int | null
     */
    public function getTimeZone()
    {
        return (int)$this->getFieldValue(\Fields::TIME_ZONE);
    }

    /**
     * @return string | null
     */
    public function getPhone()
    {
        return $this->getFieldValue(\Fields::PHONE);
    }
}
