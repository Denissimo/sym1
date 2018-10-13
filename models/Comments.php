<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="app_id", columns={"app_id"}), @ORM\Index(name="ictype", columns={"ctype"}), @ORM\Index(name="ts", columns={"ts"}), @ORM\Index(name="uid", columns={"uid"})})
 * @ORM\Entity
 */
class Comments
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
     * @var int
     *
     * @ORM\Column(name="app_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $appId;

    /**
     * @var \Apps
     * @ORM\ManyToOne(targetEntity="\Apps", inversedBy="comments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="app_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $app;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ts", type="datetime", nullable=true)
     */
    private $ts;

    /**
     * @var int|null
     *
     * @ORM\Column(name="uid", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $uid = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="reminder", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $reminder = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="string", length=1000, nullable=true)
     */
    private $comment = '';

    /**
     * @var \CommentTypes
     *
     * @ORM\ManyToOne(targetEntity="CommentTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ctype", referencedColumnName="id")
     * })
     */
    private $ctype;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getAppId(): int
    {
        return $this->appId;
    }

    /**
     * @param int $appId
     */
    public function setAppId(int $appId)
    {
        $this->appId = $appId;
    }

    /**
     * @return Apps
     */
    public function getApp(): Apps
    {
        return $this->app;
    }

    /**
     * @param Apps $app
     */
    public function setApp(Apps $app)
    {
        $this->app = $app;
    }

    /**
     * @return DateTime|null
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * @param DateTime|null $ts
     */
    public function setTs($ts)
    {
        $this->ts = $ts;
    }

    /**
     * @return int|null
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param int|null $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return int|null
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    /**
     * @param int|null $reminder
     */
    public function setReminder($reminder)
    {
        $this->reminder = $reminder;
    }

    /**
     * @return null|string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param null|string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return CommentTypes
     */
    public function getCtype(): CommentTypes
    {
        return $this->ctype;
    }

    /**
     * @param CommentTypes $ctype
     */
    public function setCtype(CommentTypes $ctype)
    {
        $this->ctype = $ctype;
    }

}
