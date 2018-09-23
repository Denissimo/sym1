<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AppLog
 *
 * @ORM\Table(name="app_log", indexes={@ORM\Index(name="IDX_A14DDB0272F5A1AA", columns={"channel_id"}), @ORM\Index(name="IDX_A14DDB027987212D", columns={"app_id"}), @ORM\Index(name="log_status_index", columns={"status"}), @ORM\Index(name="ts_index", columns={"ts"})})
 * @ORM\Entity
 */
class AppLog
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
     * @ORM\Column(name="channel_id", type="integer", nullable=false)
     */
    private $channelId = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ts", type="datetime", nullable=false)
     */
    private $ts;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="success", type="boolean", nullable=true)
     */
    private $success;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=true)
     */
    private $message;

    /**
     * @var \Apps
     *
     * @ORM\ManyToOne(targetEntity="Apps")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="app_id", referencedColumnName="id")
     * })
     */
    private $app;

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
    public function getChannelId(): int
    {
        return $this->channelId;
    }

    /**
     * @return DateTime
     */
    public function getTs(): DateTime
    {
        return $this->ts;
    }

    /**
     * @return int|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return bool|null
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @return null|string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return Apps
     */
    public function getApp(): Apps
    {
        return $this->app;
    }


}
