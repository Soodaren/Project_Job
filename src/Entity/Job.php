<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=JobRepository::class)
 */
class Job
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="This field cannot be empty!")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="This field cannot be empty!")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="This field cannot be empty!")
     */
    private $qualification;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="This field cannot be empty!")
     * @Assert\Regex(pattern = "/^\d{5,6}/", message="Must contain numbers only and must be between 5-6 digits")
     */
    private $salary;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="This field cannot be empty!")
     * @Assert\GreaterThan("today")
     */
    private $deadline_date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please upload an image in either png or jpeg format.")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" }, mimeTypesMessage="Please upload an image in either png or jpeg format")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Apply::class, mappedBy="job", orphanRemoval=true)
     */
    private $applies;

    public function __construct()
    {
        $this->applies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    public function setQualification(string $qualification): self
    {
        $this->qualification = $qualification;

        return $this;
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function setSalary($salary): void
    {
        $this->salary = $salary;
    }

    public function getDeadlineDate(): ?\DateTimeInterface
    {
        return $this->deadline_date;
    }

    public function setDeadlineDate(\DateTimeInterface $deadline_date): self
    {
        $this->deadline_date = $deadline_date;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Apply[]
     */
    public function getApplies(): Collection
    {
        return $this->applies;
    }

    public function addApply(Apply $apply): self
    {
        if (!$this->applies->contains($apply)) {
            $this->applies[] = $apply;
            $apply->setJob($this);
        }

        return $this;
    }

    public function removeApply(Apply $apply): self
    {
        if ($this->applies->removeElement($apply)) {
            // set the owning side to null (unless already changed)
            if ($apply->getJob() === $this) {
                $apply->setJob(null);
            }
        }

        return $this;
    }

}
