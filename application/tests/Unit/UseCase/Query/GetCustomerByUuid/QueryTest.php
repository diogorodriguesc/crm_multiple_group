<?php
declare(strict_types=1);

namespace App\Tests\Unit\UseCase\Query\GetCustomerByUuid;

use App\UseCase\Query\GetCustomerById\Query;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class QueryTest extends TestCase
{
    public function testQuery(): void
    {
        $query = new Query(1);

        self::assertEquals(1, $query->id);
    }
}