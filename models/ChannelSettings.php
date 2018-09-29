<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ChannelSettings
 *
 * @ORM\Table(name="channel_settings", indexes={@ORM\Index(name="channel_index", columns={"channel_id"})})
 * @ORM\Entity
 */
class ChannelSettings
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateStart", type="datetime", nullable=false)
     */
    private $datestart;

    /**
     * @var \Channels
     *
     * @ORM\ManyToOne(targetEntity="Channels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="channel_id", referencedColumnName="id")
     * })
     */
    private $channel;


}
