<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Partners
 *
 * @ORM\Table(name="partners")
 * @ORM\Entity
 */
class Partners
{
    const
        TITLE = 'title',
        PID = 'pid';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="info", type="text", length=0, nullable=true)
     */
    private $info;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Partners
     */
    public function setId(int $id): Partners
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Partners
     */
    public function setTitle(string $title): Partners
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param null|string $info
     * @return Partners
     */
    public function setInfo($info)
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Partners
     */
    public function setEmail(string $email): Partners
    {
        $this->email = $email;
        return $this;
    }
}
