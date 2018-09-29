<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SysUrls
 *
 * @ORM\Table(name="sys_urls")
 * @ORM\Entity
 */
class SysUrls
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
     * @ORM\Column(name="path", type="string", length=75, nullable=true)
     */
    private $path;

    /**
     * @var string|null
     *
     * @ORM\Column(name="scrip", type="string", length=75, nullable=true)
     */
    private $scrip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="template", type="string", length=75, nullable=true)
     */
    private $template;

    /**
     * @var string|null
     *
     * @ORM\Column(name="parent", type="string", length=64, nullable=true)
     */
    private $parent;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="independ", type="boolean", nullable=true)
     */
    private $independ;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=64, nullable=true)
     */
    private $label;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="level", type="boolean", nullable=true)
     */
    private $level;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string|null
     *
     * @ORM\Column(name="h1", type="string", length=255, nullable=true)
     */
    private $h1;

    /**
     * @var string
     *
     * @ORM\Column(name="menu", type="string", length=75, nullable=false)
     */
    private $menu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="text", length=65535, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="keywords", type="text", length=65535, nullable=true)
     */
    private $keywords;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="noindex", type="boolean", nullable=true)
     */
    private $noindex;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="access", type="boolean", nullable=true)
     */
    private $access;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="virtual", type="boolean", nullable=true)
     */
    private $virtual;

    /**
     * @var string|null
     *
     * @ORM\Column(name="header", type="text", length=65535, nullable=true)
     */
    private $header;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="comments", type="boolean", nullable=true)
     */
    private $comments = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="slash", type="boolean", nullable=true)
     */
    private $slash;


}
