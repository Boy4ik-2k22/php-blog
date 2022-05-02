<?php

namespace Blog\Test\Unit;

use Blog\Database;
use PDO;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    /**
     * @var Database
     */
    private Database $object;

    /**
     * @var MockObject|Database
     */
    private MockObject $connection;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->connection = $this->createMock(PDO::class);
        $this->object = new Database($this->connection);
    }

    /**
     * @return void
     */
    public function testGetConnection(): void
    {
        $result = $this->object->getConnection();

        $this->assertInstanceOf(PDO::class, $result);
    }
}