<?php

namespace Pinkeen\CascadaDemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Book
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected  $id;

    /**
     * @ORM\Column(type="string", length=256)
     *
     * @var string
     */
    protected $title;

    /**
     * @ORM\ManyToOne(targetEntity="author", inversedBy="books")
     *
     * @var Author
     */
    protected $author;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param Author $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }
}