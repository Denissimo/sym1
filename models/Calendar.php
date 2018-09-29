<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Calendar
 *
 * @ORM\Table(name="calendar", indexes={@ORM\Index(name="btw", columns={"ss", "se"}), @ORM\Index(name="e", columns={"e"}), @ORM\Index(name="se", columns={"se"}), @ORM\Index(name="uid", columns={"uid"}), @ORM\Index(name="wd", columns={"wd"}), @ORM\Index(name="wn", columns={"wn"})})
 * @ORM\Entity
 */
class Calendar
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
     * @ORM\Column(name="uid", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $uid = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="ss", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $ss = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="se", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $se = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="wd", type="integer", nullable=true)
     */
    private $wd = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="wn", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $wn = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="e", type="boolean", nullable=true, options={"default"="1"})
     */
    private $e = '1';


}
