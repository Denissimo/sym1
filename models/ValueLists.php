<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ValueLists
 *
 * @ORM\Table(name="value_lists", indexes={@ORM\Index(name="field_vi_index", columns={"field_id"})})
 * @ORM\Entity
 */
class ValueLists
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
     * @ORM\Column(name="value", type="string", length=255, nullable=false)
     */
    private $value;

    /**
     * @var \Fields
     *
     * @ORM\ManyToOne(targetEntity="Fields")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="field_id", referencedColumnName="id")
     * })
     */
    private $field;


}
