<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_1483A5E9E7927C74", columns={"email"}), @ORM\UniqueConstraint(name="UNIQ_1483A5E99393F8FE", columns={"partner_id"})}, indexes={@ORM\Index(name="enabled", columns={"enabled"}), @ORM\Index(name="in_action", columns={"in_action"}), @ORM\Index(name="priority", columns={"priority"}), @ORM\Index(name="show_in_filter", columns={"show_in_filter"})})
 * @ORM\Entity
 */
class Users
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="in_action", type="boolean", nullable=true, options={"default"="1"})
     */
    private $inAction = '1';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="show_in_filter", type="boolean", nullable=true, options={"default"="1"})
     */
    private $showInFilter = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="priority", type="integer", nullable=true)
     */
    private $priority = '0';

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Roles", inversedBy="user")
     * @ORM\JoinTable(name="users_roles",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     *   }
     * )
     */
    private $role;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->role = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return bool|null
     */
    public function getInAction()
    {
        return $this->inAction;
    }

    /**
     * @return bool|null
     */
    public function getShowInFilter()
    {
        return $this->showInFilter;
    }

    /**
     * @return int|null
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return Partners
     */
    public function getPartner(): Partners
    {
        return $this->partner;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRole(): \Doctrine\Common\Collections\Collection
    {
        return $this->role;
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
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param bool $enabled
     * @return $this
     */
    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @param $inAction
     * @return $this
     */
    public function setInAction($inAction)
    {
        $this->inAction = $inAction;
        return $this;
    }

    /**
     * @param $showInFilter
     */
    public function setShowInFilter($showInFilter)
    {
        $this->showInFilter = $showInFilter;
    }

    /**
     * @param $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @param Partners $partner
     */
    public function setPartner(Partners $partner)
    {
        $this->partner = $partner;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $role
     * @return $this
     */
    public function setRole(\Doctrine\Common\Collections\Collection $role)
    {
        $this->role = $role;
        return $this;
    }


}
