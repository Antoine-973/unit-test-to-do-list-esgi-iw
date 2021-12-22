<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use \Carbon\Doctrine\DateTimeImmutableType;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=75)
     */
    private $mail;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthdate;

    /**
     * @ORM\OneToOne(targetEntity=ToDoList::class, inversedBy="utilisateur", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $ToDoList;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = password_hash( $password , PASSWORD_DEFAULT);

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getBirthdate()

    {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getToDoList(): ?ToDoList
    {
        return $this->ToDoList;
    }

    public function setToDoList(ToDoList $ToDoList): self
    {
        $this->ToDoList = $ToDoList;

        return $this;
    }

    public function isValid(): bool
    {
        return !empty($this->email)
            && filter_var($this->email, FILTER_VALIDATE_EMAIL)
            && !empty($this->fname)
            && !empty($this->lname)
            && !is_null($this->birthdate)
            && $this->birthdate->addYears(13)->isBefore(Carbon::now());
    }
}
