<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Game
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
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coverImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $nextGameAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserGame", mappedBy="games", orphanRemoval=true)
     */
    private $userGames;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameSlide", mappedBy="game")
     */
    private $gameSlides;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GameBook", inversedBy="game", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameBook;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameNote", mappedBy="game",cascade={"persist"})
     */
    private $gameNotes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VocalServer", inversedBy="game")
     */
    private $vocalServer;

    public function __construct()
    {
        $this->userGames = new ArrayCollection();
        $this->gameSlides = new ArrayCollection();
        $this->gameNotes = new ArrayCollection();
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
            $this->slug = $slugify->slugify($this->title);
        }
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    public function __toString(): string
    {
        return $this->title;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): self
    {
        $this->coverImage = $coverImage;

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

    public function getNextGameAt(): ?\DateTimeInterface
    {
        return $this->nextGameAt;
    }

    public function setNextGameAt(?\DateTimeInterface $nextGameAt): self
    {
        $this->nextGameAt = $nextGameAt;

        return $this;
    }

    public function getOwner(): ?int
    {
        return $this->owner;
    }

    public function setOwner(int $owner): self
    {
        $this->owner = $owner;

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
            $userGame->setGames($this);
        }
        return $this;
    }

    public function removeUserGame(UserGame $userGame): self
    {
        if ($this->userGames->contains($userGame)) {
            $this->userGames->removeElement($userGame);
            // set the owning side to null (unless already changed)
            if ($userGame->getGames() === $this) {
                $userGame->setGames(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|GameSlide[]
     */
    public function getGameSlides(): Collection
    {
        return $this->gameSlides;
    }

    public function addGameSlide(GameSlide $gameSlide): self
    {
        if (!$this->gameSlides->contains($gameSlide)) {
            $this->gameSlides[] = $gameSlide;
            $gameSlide->setGame($this);
        }

        return $this;
    }

    public function removeGameSlide(GameSlide $gameSlide): self
    {
        if ($this->gameSlides->contains($gameSlide)) {
            $this->gameSlides->removeElement($gameSlide);
            // set the owning side to null (unless already changed)
            if ($gameSlide->getGame() === $this) {
                $gameSlide->setGame(null);
            }
        }

        return $this;
    }

    public function getGameBook(): ?GameBook
    {
        return $this->gameBook;
    }

    public function setGameBook(?GameBook $gameBook): self
    {
        $this->gameBook = $gameBook;

        return $this;
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
            $gameNote->setGame($this);
        }

        return $this;
    }

    public function removeGameNote(GameNote $gameNote): self
    {
        if ($this->gameNotes->contains($gameNote)) {
            $this->gameNotes->removeElement($gameNote);
            // set the owning side to null (unless already changed)
            if ($gameNote->getGame() === $this) {
                $gameNote->setGame(null);
            }
        }

        return $this;
    }

    public function getVocalServer(): ?VocalServer
    {
        return $this->vocalServer;
    }

    public function setVocalServer(?VocalServer $vocalServer): self
    {
        $this->vocalServer = $vocalServer;

        return $this;
    }
}
