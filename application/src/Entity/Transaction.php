<?php
declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'guid', length: 36)]
    #[Assert\NotBlank]
    #[Assert\Uuid]
    private string $uuid;

    #[ManyToOne(targetEntity: Customer::class, inversedBy: 'customer')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Customer $sourceAccount;

    #[ManyToOne(targetEntity: Customer::class, inversedBy: 'customer')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Customer $destinationAccount;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $description;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2, nullable: true)]
    #[Assert\NotBlank]
    private ?string $amount;

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $cancelledAt;

    private function __construct(
        string $description = '',
        ?Customer $sourceAccount = null,
        ?Customer $destinationAccount = null,
        ?string $amount = null
    )
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->description = $description;
        $this->amount = $amount;
        $this->sourceAccount = $sourceAccount;
        $this->destinationAccount = $destinationAccount;
        $this->createdAt = new DateTime();
    }

    public static function createAccountTransaction(Customer $customer): self
    {
        return new self(
            description: 'Customer Created',
            sourceAccount: $customer,
        );
    }

    public static function createDepositTransaction(Customer $customer, float $funds): self
    {
        return new self(
            description: 'Deposit',
            sourceAccount: $customer,
            amount: (string) $funds,
        );
    }

    public static function createWithdrawTransaction(Customer $customer, float $funds): self
    {
        return new self(
            description: 'Withdraw',
            sourceAccount: $customer,
            amount: (string) $funds,
        );
    }

    public static function createTransferTransaction(
        Customer $sourceCustomer,
        Customer $destinationCustomer,
        float $funds
    ): self
    {
        return new self(
            description: 'Transfer between customers',
            sourceAccount: $sourceCustomer,
            destinationAccount: $destinationCustomer,
            amount: (string) $funds,
        );
    }

    public static function createDeletionTransaction(
        Customer $sourceCustomer
    ): self
    {
        return new self(
            description: 'Account Deleted',
            sourceAccount: $sourceCustomer,
        );
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function sourceAccount(): ?Customer
    {
        return $this->sourceAccount;
    }

    public function destinationAccount(): ?Customer
    {
        return $this->destinationAccount;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function amount(): string
    {
        return $this->amount;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function cancelledAt(): ?DateTime
    {
        return $this->cancelledAt;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function cancelTransaction(): self
    {
        $this->cancelledAt = new DateTime();

        return $this;
    }
}
