<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"email"},
 *     message="L'email '{{ value }}' est déja utilisé."
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le prenom doit avoir minimum {{ limit }} caractères",
     *      maxMessage = "Le prenom ne peut pas avoir plus de  {{ limit }} caractères"
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit avoir minimum {{ limit }} caractères",
     *      maxMessage = "Le nom ne peut pas avoir plus de  {{ limit }} caractères"
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "L' email '{{ value }}' n'est pas valide."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nickName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 8,
     *      max = 50,
     *       minMessage = "L'introduction doit avoir minimum {{ limit }} caractères",
     *      maxMessage = "L'introduction ne peut pas avoir plus de  {{ limit }} caractères"
     * )
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $longDescription;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern="/(?=.*[0-9])/",
     *     match=true,
     *     message="Votre password doit contenir un caractère alphanumeric"
     * )
     * @Assert\Regex(
     *     pattern="/(?=.*[A-Z])/",
     *     match=true,
     *     message="Votre password doit contenir un caractère majuscule"
     * )
     * @Assert\Regex(
     *     pattern="/(?=.*\W)/",
     *     match=true,
     *     message="Votre password doit contenir un caractère spciale"
     * )
     */
    private $hash;

    /**
     * @Assert\EqualTo(propertyPath="hash", message="Les mot de passe sont différents")
     */
    public $passwordConfirm;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserGame", mappedBy="users")
     */
    private $userGames;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="owner")
     */
    private $games;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameNote", mappedBy="user")
     */
    private $gameNotes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", mappedBy="users")
     */
    private $userRole;

    public function __construct()
    {
        $this->userGames = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->gameNotes = new ArrayCollection();
        $this->userRole = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Initialize Slug
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function initializeSlug()
    {
        if(empty($this->slug)) {
            $slugify = NEW Slugify();
            $this->slug = $slugify->slugify($this->firstName . '' . $this->lastName);
        }
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    public function setNickName(string $nickName): self
    {
        $this->nickName = $nickName;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nickName;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function setLongDescription(?string $longDescription): self
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return Collection|UserGame[]
     */
    public function getUserGames(): Collection
    {
        return $this->userGames;
    }

    public function addUserGame(UserGame $userGame): self
    {
        if (!$this->userGames->contains($userGame)) {
            $this->userGames[] = $userGame;
            $userGame->setUsers($this);
        }

        return $this;
    }

    public function removeUserGame(UserGame $userGame): self
    {
        if ($this->userGames->contains($userGame)) {
            $this->userGames->removeElement($userGame);
            // set the owning side to null (unless already changed)
            if ($userGame->getUsers() === $this) {
                $userGame->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setMj($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getMj() === $this) {
                $game->setMj(null);
            }
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles = $this->userRole->map(function ($role){

            return $role->getTitle();
        })->toArray();
        $roles[] = 'ROLE_USER';

        return $roles;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->hash;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getFullName()
    {
        return "{$this->getFirstName()} {$this->getLastName()}";
    }

    /**
     * @return Collection|GameNote[]
     */
    public function getGameNotes(): Collection
    {
        return $this->gameNotes;
    }

    public function addGameNote(GameNote $gameNote): self
    {
        if (!$this->gameNotes->contains($gameNote)) {
            $this->gameNotes[] = $gameNote;
            $gameNote->setUser($this);
        }

        return $this;
    }

    public function removeGameNote(GameNote $gameNote): self
    {
        if ($this->gameNotes->contains($gameNote)) {
            $this->gameNotes->removeElement($gameNote);
            // set the owning side to null (unless already changed)
            if ($gameNote->getUser() === $this) {
                $gameNote->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRole(): Collection
    {
        return $this->userRole;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRole->contains($userRole)) {
            $this->userRole[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRole->contains($userRole)) {
            $this->userRole->removeElement($userRole);
            $userRole->removeUser($this);
        }

        return $this;
    }
}
