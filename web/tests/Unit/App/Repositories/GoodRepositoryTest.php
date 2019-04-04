<?php

namespace Tests\Unit\App\Repositories;

use App\Repositories\GoodRepository;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Tests\TestConstants;

class GoodRepositoryTest extends TestCase
{
    use TestConstants;

    public function testGetById()
    {
        $this->getById(self::$good1);
    }

    public function testGetByIdCase2()
    {
        $this->getById(self::$good2);
    }

    private function getById(array $needleGood)
    {
        $actualGood = app(GoodRepository::class)->getById($needleGood['id']);

        $this->assertEquals($needleGood, Arr::only($actualGood->toArray(), array_keys($needleGood)));
    }
}
