<?php

namespace SFBCN\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SFBCN\WebsiteBundle\Entity\Event
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="SFBCN\WebsiteBundle\Entity\EventRepository")
 */
class Event
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var text $body
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string $location
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string $photo
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;

    /**
     * @var string $file1
     *
     * @ORM\Column(name="file1", type="string", length=255)
     */
    private $file1;

    /**
     * @var string $file2
     *
     * @ORM\Column(name="file2", type="string", length=255)
     */
    private $file2;


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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param text $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Get body
     *
     * @return text 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set photo
     *
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set file1
     *
     * @param string $file1
     */
    public function setFile1($file1)
    {
        $this->file1 = $file1;
    }

    /**
     * Get file1
     *
     * @return string 
     */
    public function getFile1()
    {
        return $this->file1;
    }

    /**
     * Set file2
     *
     * @param string $file2
     */
    public function setFile2($file2)
    {
        $this->file2 = $file2;
    }

    /**
     * Get file2
     *
     * @return string 
     */
    public function getFile2()
    {
        return $this->file2;
    }
}