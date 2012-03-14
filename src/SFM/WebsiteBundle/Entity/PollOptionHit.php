<?php

namespace SFM\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SFM\WebsiteBundle\Entity\PollOptionHit
 *
 * @ORM\Table(name="polls_options_hits")
 * @ORM\Entity(repositoryClass="SFM\WebsiteBundle\Repository\PollOptionHitRepository")
 */
class PollOptionHit {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $session
     *
     * @ORM\Column(name="session", type="string", length=64)
     */
    private $session;

    /**
     * @var string $ip
     *
     * @ORM\Column(name="ip", type="string", length=16)
     */
    private $ip;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
    
    
    /**
     * @var integer $poll_option_id
     *
     * @ORM\Column(name="poll_option_id", type="integer")
     */
    private $poll_option_id;

    /**
     * @ORM\ManyToOne(targetEntity="PollOption", inversedBy="hits")
     * @ORM\JoinColumn(name="poll_option_id", referencedColumnName="id")
     */
    private $poll_option;

    public function __construct() {
        $this->date = new \DateTime('now');
        $this->session = session_id();
        $this->ip = $_SERVER['REMOTE_ADDR'];        
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set session
     *
     * @param string $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * Get session
     *
     * @return string 
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set ip
     *
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set date
     *
     * @param datetime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set poll_option
     *
     * @param SFM\WebsiteBundle\Entity\PollOption $pollOption
     */
    public function setPollOption(\SFM\WebsiteBundle\Entity\PollOption $pollOption)
    {
        $this->poll_option = $pollOption;
    }

    /**
     * Get poll_option
     *
     * @return SFM\WebsiteBundle\Entity\PollOption 
     */
    public function getPollOption()
    {
        return $this->poll_option;
    }

    /**
     * Set poll_option_id
     *
     * @param integer $pollOptionId
     */
    public function setPollOptionId($pollOptionId)
    {
        $this->poll_option_id = $pollOptionId;
    }

    /**
     * Get poll_option_id
     *
     * @return integer 
     */
    public function getPollOptionId()
    {
        return $this->poll_option_id;
    }
}