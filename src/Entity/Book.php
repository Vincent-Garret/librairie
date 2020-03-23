<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    //je créer un id qui s'auto incremente
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    //je créer une colonne type string qui s'appelle title
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    //je créer une colonne resume
    /**
     * @ORM\Column(type="text")
     */
    private $resume;

    //je créer une colonne author de type string
    /**
     * @ORM\column(type="string", length=255)
     */
    private $author;

    //je créer une colonne de type int
    /**
     * @ORM\column(type="integer")
     */
    private $nbPages;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getResume(): ?string
    {
        return $this->resume;
    }
    public function getAuthor(): ?string
    {
        return $this->author;
    }
    public function getNbPages(): ?int
    {
        return $this->nbPages;
    }
}
