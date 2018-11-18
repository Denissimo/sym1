<?php


use Doctrine\ORM\Mapping as ORM;

/**
 * UsersSchedule
 *
 * @ORM\Table(name="users_schedule", indexes={@ORM\Index(name="FK_users_schedule_user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class UsersSchedule
{
    private static $days = [
        'Monday' => 'Понедельник',
        'Tuesday' => 'Вторник',
        'Wednesday' => 'Среда',
        'Thursday' => 'Четверг',
        'Friday' => 'Пятница',
        'Saturday' => 'Суббота',
        'Sunday' => 'Воскресенье',
    ];
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="type", type="boolean", nullable=true)
     */
    private $type = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_from", type="datetime", nullable=true)
     */
    private $dateFrom;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_to", type="datetime", nullable=true)
     */
    private $dateTo;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UsersSchedule
     */
    public function setId(int $id): UsersSchedule
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool|null $enabled
     * @return UsersSchedule
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param bool|null $type
     * @return UsersSchedule
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param DateTime|null $dateFrom
     * @return UsersSchedule
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param DateTime|null $dateTo
     * @return UsersSchedule
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
        return $this;
    }

    /**
     * @return Users
     */
    public function getUser(): Users
    {
        return $this->user;
    }

    /**
     * @param Users $user
     * @return UsersSchedule
     */
    public function setUser(Users $user): UsersSchedule
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateFromString()
    {
        return $this->dateFrom->format('d.m.Y_H:i');
    }

    /**
     * @return string
     */
    public function getDateToString()
    {
        return $this->dateTo->format('d.m.Y_H:i');
    }

    /**
     * @return string
     */
    public function getDayFrom()
    {
        return self::$days[$this->dateFrom->format('l')] . '_'
            . $this->dateFrom->format('H:i');
    }

    /**
     * @return string
     */
    public function getDayTo()
    {
        return self::$days[$this->dateTo->format('l')] . '_'
            . $this->dateTo->format('H:i');
    }

}
