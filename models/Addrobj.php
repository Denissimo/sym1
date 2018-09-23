<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Addrobj
 *
 * @ORM\Table(name="addrobj", indexes={@ORM\Index(name="aoguid", columns={"aoguid"}), @ORM\Index(name="children_index", columns={"has_children"}), @ORM\Index(name="formalname", columns={"formalname"}), @ORM\Index(name="formalname2", columns={"formalname2"}), @ORM\Index(name="level", columns={"aolevel"}), @ORM\Index(name="orderid", columns={"orderid"}), @ORM\Index(name="regioncode", columns={"regioncode"}), @ORM\Index(name="shortname", columns={"shortname"}), @ORM\Index(name="FK_376B61875DA7B52D", columns={"parentguid"})})
 * @ORM\Entity
 */
class Addrobj
{
    /**
     * @return string
     */
    public function getAoguid(): string
    {
        return $this->aoguid;
    }

    /**
     * @return string
     */
    public function getFormalname(): string
    {
        return $this->formalname;
    }

    /**
     * @return string
     */
    public function getFormalname2(): string
    {
        return $this->formalname2;
    }

    /**
     * @return string
     */
    public function getRegioncode(): string
    {
        return $this->regioncode;
    }

    /**
     * @return string
     */
    public function getAutocode(): string
    {
        return $this->autocode;
    }

    /**
     * @return string
     */
    public function getAreacode(): string
    {
        return $this->areacode;
    }

    /**
     * @return string
     */
    public function getCitycode(): string
    {
        return $this->citycode;
    }

    /**
     * @return string
     */
    public function getCtarcode(): string
    {
        return $this->ctarcode;
    }

    /**
     * @return string
     */
    public function getPlacecode(): string
    {
        return $this->placecode;
    }

    /**
     * @return string
     */
    public function getStreetcode(): string
    {
        return $this->streetcode;
    }

    /**
     * @return string
     */
    public function getExtrcode(): string
    {
        return $this->extrcode;
    }

    /**
     * @return string
     */
    public function getSextcode(): string
    {
        return $this->sextcode;
    }

    /**
     * @return string
     */
    public function getOffname(): string
    {
        return $this->offname;
    }

    /**
     * @return string
     */
    public function getPostalcode(): string
    {
        return $this->postalcode;
    }

    /**
     * @return string
     */
    public function getIfnsfl(): string
    {
        return $this->ifnsfl;
    }

    /**
     * @return string
     */
    public function getTerrifnsfl(): string
    {
        return $this->terrifnsfl;
    }

    /**
     * @return string
     */
    public function getIfnsul(): string
    {
        return $this->ifnsul;
    }

    /**
     * @return string
     */
    public function getTerrifnsul(): string
    {
        return $this->terrifnsul;
    }

    /**
     * @return string
     */
    public function getOkato(): string
    {
        return $this->okato;
    }

    /**
     * @return string
     */
    public function getOktmo(): string
    {
        return $this->oktmo;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedate(): DateTime
    {
        return $this->updatedate;
    }

    /**
     * @return string
     */
    public function getShortname(): string
    {
        return $this->shortname;
    }

    /**
     * @return int
     */
    public function getAolevel(): int
    {
        return $this->aolevel;
    }

    /**
     * @return string
     */
    public function getPrevid(): string
    {
        return $this->previd;
    }

    /**
     * @return string
     */
    public function getNextid(): string
    {
        return $this->nextid;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getPlaincode(): string
    {
        return $this->plaincode;
    }

    /**
     * @return bool
     */
    public function isActstatus(): bool
    {
        return $this->actstatus;
    }

    /**
     * @return int
     */
    public function getCentstatus(): int
    {
        return $this->centstatus;
    }

    /**
     * @return int
     */
    public function getOperstatus(): int
    {
        return $this->operstatus;
    }

    /**
     * @return int
     */
    public function getCurrstatus(): int
    {
        return $this->currstatus;
    }

    /**
     * @return DateTime
     */
    public function getStartdate(): DateTime
    {
        return $this->startdate;
    }

    /**
     * @return DateTime
     */
    public function getEnddate(): DateTime
    {
        return $this->enddate;
    }

    /**
     * @return string
     */
    public function getNormdoc(): string
    {
        return $this->normdoc;
    }

    /**
     * @return int|null
     */
    public function getLivestatus()
    {
        return $this->livestatus;
    }

    /**
     * @return int|null
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * @return bool
     */
    public function isHasChildren(): bool
    {
        return $this->hasChildren;
    }

    /**
     * @return Addrobj
     */
    public function getParentguid(): Addrobj
    {
        return $this->parentguid;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="aoguid", type="string", length=36, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $aoguid;

    /**
     * @var string
     *
     * @ORM\Column(name="formalname", type="string", length=120, nullable=false)
     */
    private $formalname;

    /**
     * @var string
     *
     * @ORM\Column(name="formalname2", type="string", length=120, nullable=false)
     */
    private $formalname2;

    /**
     * @var string
     *
     * @ORM\Column(name="regioncode", type="string", length=2, nullable=false)
     */
    private $regioncode;

    /**
     * @var string
     *
     * @ORM\Column(name="autocode", type="string", length=1, nullable=false)
     */
    private $autocode;

    /**
     * @var string
     *
     * @ORM\Column(name="areacode", type="string", length=3, nullable=false)
     */
    private $areacode;

    /**
     * @var string
     *
     * @ORM\Column(name="citycode", type="string", length=3, nullable=false)
     */
    private $citycode;

    /**
     * @var string
     *
     * @ORM\Column(name="ctarcode", type="string", length=3, nullable=false)
     */
    private $ctarcode;

    /**
     * @var string
     *
     * @ORM\Column(name="placecode", type="string", length=3, nullable=false)
     */
    private $placecode;

    /**
     * @var string
     *
     * @ORM\Column(name="streetcode", type="string", length=4, nullable=false)
     */
    private $streetcode;

    /**
     * @var string
     *
     * @ORM\Column(name="extrcode", type="string", length=4, nullable=false)
     */
    private $extrcode;

    /**
     * @var string
     *
     * @ORM\Column(name="sextcode", type="string", length=3, nullable=false)
     */
    private $sextcode;

    /**
     * @var string
     *
     * @ORM\Column(name="offname", type="string", length=120, nullable=false)
     */
    private $offname;

    /**
     * @var string
     *
     * @ORM\Column(name="postalcode", type="string", length=6, nullable=false)
     */
    private $postalcode;

    /**
     * @var string
     *
     * @ORM\Column(name="ifnsfl", type="string", length=4, nullable=false)
     */
    private $ifnsfl;

    /**
     * @var string
     *
     * @ORM\Column(name="terrifnsfl", type="string", length=4, nullable=false)
     */
    private $terrifnsfl;

    /**
     * @var string
     *
     * @ORM\Column(name="ifnsul", type="string", length=4, nullable=false)
     */
    private $ifnsul;

    /**
     * @var string
     *
     * @ORM\Column(name="terrifnsul", type="string", length=4, nullable=false)
     */
    private $terrifnsul;

    /**
     * @var string
     *
     * @ORM\Column(name="okato", type="string", length=11, nullable=false)
     */
    private $okato;

    /**
     * @var string
     *
     * @ORM\Column(name="oktmo", type="string", length=8, nullable=false)
     */
    private $oktmo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedate", type="date", nullable=false)
     */
    private $updatedate;

    /**
     * @var string
     *
     * @ORM\Column(name="shortname", type="string", length=10, nullable=false)
     */
    private $shortname;

    /**
     * @var int
     *
     * @ORM\Column(name="aolevel", type="integer", nullable=false)
     */
    private $aolevel;

    /**
     * @var string
     *
     * @ORM\Column(name="previd", type="string", length=36, nullable=false)
     */
    private $previd;

    /**
     * @var string
     *
     * @ORM\Column(name="nextid", type="string", length=36, nullable=false)
     */
    private $nextid;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=17, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="plaincode", type="string", length=15, nullable=false)
     */
    private $plaincode;

    /**
     * @var bool
     *
     * @ORM\Column(name="actstatus", type="boolean", nullable=false)
     */
    private $actstatus;

    /**
     * @var int
     *
     * @ORM\Column(name="centstatus", type="integer", nullable=false)
     */
    private $centstatus;

    /**
     * @var int
     *
     * @ORM\Column(name="operstatus", type="integer", nullable=false)
     */
    private $operstatus;

    /**
     * @var int
     *
     * @ORM\Column(name="currstatus", type="integer", nullable=false)
     */
    private $currstatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="date", nullable=false)
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="date", nullable=false)
     */
    private $enddate;

    /**
     * @var string
     *
     * @ORM\Column(name="normdoc", type="string", length=36, nullable=false)
     */
    private $normdoc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="livestatus", type="integer", nullable=true)
     */
    private $livestatus;

    /**
     * @var int|null
     *
     * @ORM\Column(name="orderid", type="integer", nullable=true)
     */
    private $orderid;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_children", type="boolean", nullable=false)
     */
    private $hasChildren;

    /**
     * @var \Addrobj
     *
     * @ORM\ManyToOne(targetEntity="Addrobj")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parentguid", referencedColumnName="aoguid")
     * })
     */
    private $parentguid;


}
