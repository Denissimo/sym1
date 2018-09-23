<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ForeignApps
 *
 * @ORM\Table(name="foreign_apps", indexes={@ORM\Index(name="foreign_lead_id_index", columns={"foreignLeadId"}), @ORM\Index(name="foreign_tmp_id_index", columns={"foreignTmpId"}), @ORM\Index(name="IDX_A38EA2BAF643006", columns={"app_log_id"}), @ORM\Index(name="target_index", columns={"target"})})
 * @ORM\Entity
 */
class ForeignApps
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
     * @ORM\Column(name="target", type="string", length=255, nullable=true)
     */
    private $target;

    /**
     * @var string|null
     *
     * @ORM\Column(name="foreignTmpId", type="string", length=255, nullable=true)
     */
    private $foreigntmpid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="foreignLeadId", type="string", length=255, nullable=true)
     */
    private $foreignleadid;

    /**
     * @var bool
     *
     * @ORM\Column(name="success", type="boolean", nullable=false)
     */
    private $success;

    /**
     * @var int
     *
     * @ORM\Column(name="sum", type="integer", nullable=false)
     */
    private $sum = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="foreignStatusText", type="string", length=255, nullable=true)
     */
    private $foreignstatustext;

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
     * @var \AppLog
     *
     * @ORM\ManyToOne(targetEntity="AppLog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="app_log_id", referencedColumnName="id")
     * })
     */
    private $appLog;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return null|string
     */
    public function getForeigntmpid()
    {
        return $this->foreigntmpid;
    }

    /**
     * @return null|string
     */
    public function getForeignleadid()
    {
        return $this->foreignleadid;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * @return null|string
     */
    public function getForeignstatustext()
    {
        return $this->foreignstatustext;
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
     * @return AppLog
     */
    public function getAppLog(): AppLog
    {
        return $this->appLog;
    }


}
