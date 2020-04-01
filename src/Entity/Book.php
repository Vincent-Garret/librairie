<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @assert\NotBlank(message="Merci de remplir le titre")
     */
    private $title;

    //je créer une colonne resume
    /**
     * @ORM\Column(type="text")
     * @assert\Length(min = 20,
     * minMessage="Vous devez saisir un résumé de plus de 20 caracthères"
     * )
     *
     */
    private $resume;


    //je créer une colonne de type int
    /**
     * @ORM\column(type="integer")
     * @assert\LessThan(3000)
     * @assert\GreaterThan(20)
     */

    private $nbPages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="books")
     */
    private $author;



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

    public function getNbPages(): ?int
    {
        return $this->nbPages;
    }
    public function setTitle($title): ?string
    {
        return $this->title = $title;
    }
    public function setResume($resume): ?string
    {
        return $this->resume = $resume;
    }

    public function setNbPages($nbPages): ?int
    {
        return $this->nbPages = $nbPages;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }
    /**
     * @ORM\Column(type="string")
     */
    private $cover;

    public function getCover()
    {
        return $this->cover;
    }

    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }
   
    


}
