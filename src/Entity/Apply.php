<?php

namespace App\Entity;

use App\Repository\ApplyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ApplyRepository::class)
 */
class Apply
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $Apply_date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(mimeTypes={ "application/doc", "application/pdf" }, mimeTypesMessage="Please upload your cv in either doc or pdf format")
     */
    private $cv;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="applies")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Job::class, inversedBy="applies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $job;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApplyDate(): ?\DateTimeInterface
    {
        return $this->Apply_date;
    }

    public function setApplyDate(\DateTimeInterface $Apply_date): self
    {
        $this->Apply_date = $Apply_date;

        return $this;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv(string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }

}
