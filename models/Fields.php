<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Fields
 *
 * @ORM\Table(name="fields", indexes={@ORM\Index(name="IDX_7EE5E388FE54D947", columns={"group_id"}), @ORM\Index(name="name_index", columns={"name"})})
 * @ORM\Entity
 */
class Fields
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
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false, options={"comment"="0 = text, 1 = text+regex, 2 = list, 3 = FIAS"})
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var string|null
     *
     * @ORM\Column(name="regex", type="string", length=255, nullable=true)
     */
    private $regex;

    /**
     * @var bool
     *
     * @ORM\Column(name="required", type="boolean", nullable=false)
     */
    private $required;

    /**
     * @var int
     *
     * @ORM\Column(name="orderid", type="integer", nullable=false)
     */
    private $orderid = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="errortitle", type="string", length=255, nullable=true)
     */
    private $errortitle = '';

    /**
     * @var \FieldGroups
     *
     * @ORM\ManyToOne(targetEntity="FieldGroups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * })
     */
    private $group;


}
