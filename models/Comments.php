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
     * @ORM\ManyToOne(targetEntity="\Apps")
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
     * @var int|null
     *
     * @ORM\Column(name="ctype", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $ctype = '0';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAppId(): int
    {
        return $this->appId;
    }

    /**
     * @return Apps
     */
    public function getApp(): Apps
    {
        return $this->app;
    }


    /**
     * @return DateTime|null
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * @return int|null
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return int|null
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    /**
     * @return null|string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return int|null
     */
    public function getCtype()
    {
        return $this->ctype;
    }

}
