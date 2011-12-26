<?php

namespace SFBCN\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SFBCN\WebsiteBundle\Entity\SFNew
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="SFBCN\WebsiteBundle\Entity\SFNewRepository")
 */
class SFNew
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
     * @var string $author
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var datetime $published_at
     *
     * @ORM\Column(name="published_at", type="datetime")
     */
    private $published_at;

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
     * Set author
     *
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set published_at
     *
     * @param datetime $publishedAt
     */
    public function setPublishedAt($publishedAt)
    {
        $this->published_at = $publishedAt;
    }

    /**
     * Get published_at
     *
     * @return datetime 
     */
    public function getPublishedAt()
    {
        return $this->published_at;
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