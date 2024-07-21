<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Exception\NoRequiredBalanceException;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['show_customer'])]
    private string $name;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['show_customer'])]
    private string $surname;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2)]
    #[Assert\NotBlank]
    #[Groups(['show_customer', 'show_funds'])]
    private string $balance;

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private $createdAt;

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private $updatedAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $cancelledAt;

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function surname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function balance(): string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function setCreatedAt(DateTime $dateTime): self
    {
        $this->createdAt = $dateTime;

        return $this;
    }

    public function setUpdatedAt(DateTime $dateTime): self
    {
        $this->updatedAt = $dateTime;

        return $this;
    }

    public function depositFunds(float $amount): self
    {
        $balance = (float)$this->balance;

        $this->balance = (string)($balance + $amount);

        return $this;
    }

    public function hasNoBalance(): bool
    {
        $balance = (float)$this->balance;

        if (0.00 === $balance) {
            return true;
        }

        return false;
    }

    public function withdrawFunds(float $amount): self
    {
        $balance = (float)$this->balance;

        if (($balance - $amount) < 0) {
            throw new NoRequiredBalanceException("No required balance to finish operation.");
        }

        $this->balance = (string)($balance - $amount);

        return $this;
    }

    public function isActive(): bool
    {
        return null === $this->cancelledAt;
    }

    public function cancelCustomer(): self
    {
        $this->cancelledAt = new DateTime();

        return $this;
    }
}
