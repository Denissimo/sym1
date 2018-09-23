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


}
