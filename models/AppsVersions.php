<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AppsVersions
 *
 * @ORM\Table(name="apps_versions", indexes={@ORM\Index(name="app_id", columns={"app_id"}), @ORM\Index(name="ts", columns={"ts"}), @ORM\Index(name="uid", columns={"uid"})})
 * @ORM\Entity
 */
class AppsVersions
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
     * @var int|null
     *
     * @ORM\Column(name="app_id", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $appId = '0';

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
     * @var string|null
     *
     * @ORM\Column(name="data", type="text", length=65535, nullable=true)
     */
    private $data;

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
    public function getAppId()
    {
        return $this->appId;
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
     * @return null|string
     */
    public function getData()
    {
        return $this->data;
    }


}
