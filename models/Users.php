<?php

use Doctrine\ORM\Mapping as ORM;
use App\Cfg\Config;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_1483A5E9E7927C74", columns={"email"}), @ORM\UniqueConstraint(name="UNIQ_1483A5E99393F8FE", columns={"partner_id"})}, indexes={@ORM\Index(name="enabled", columns={"enabled"}), @ORM\Index(name="in_action", columns={"in_action"}), @ORM\Index(name="priority", columns={"priority"}), @ORM\Index(name="show_in_filter", columns={"show_in_filter"})})
 * @ORM\Entity
 */
class Users
{
    const
        ID = 'id',
        NAME = 'name',
        EMAIL = 'email',
        PASSWORD = 'password',
        ENABLED = 'enabled',
        PRIORITY = 'priority',
        ROLE = 'role';


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
     * @var string
     *
     * @ORM\Column(name="user_pick", type="string", length=255, nullable=false)
     */
    private $userPick;

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
    public function getNameShort(): string
    {
        $nameArray = explode(' ', $this->name);
        $lastName = $nameArray[0].' ' ?? $this->name;
        $firstName = isset($nameArray[1]) ? mb_substr($nameArray[1], 0, 1).'. ' : null;
        $middleName = isset($nameArray[2]) ? mb_substr($nameArray[2], 0, 1).'. ' : null;

        return $lastName.$firstName.$middleName;
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


    public function getRoleId()
    {
        /** @var \Roles $role */
        $role = $this->role->toArray()[0];
        return $role;
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
     * @return $this
     */
    public function setShowInFilter($showInFilter)
    {
        $this->showInFilter = $showInFilter;
        return $this;
    }

    /**
     * @param $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
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
     * @param \Doctrine\Common\Collections\Collection $role
     * @return $this
     */
    public function setRole(\Doctrine\Common\Collections\Collection $role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserPick(): string
    {
        return $this->userPick ?
            Config::getDefaults()[Config::FIELD_USERPIC][Config::FIELD_PATH] . $this->userPick :
            Config::getDefaults()[Config::FIELD_USERPIC][Config::FIELD_PATH] .
            Config::getDefaults()[Config::FIELD_USERPIC][Config::FIELD_NAME];
    }

    /**
     * @param string $userPick
     * @return Users
     */
    public function setUserPick(string $userPick): Users
    {
        $this->userPick = $userPick;
        return $this;
    }

}
