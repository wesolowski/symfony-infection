<?php declare(strict_types=1);

namespace App\Tests\Unit\Service\Validator\Collection;

use App\Service\Validator\Collection\Brand;
use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    private Brand $brand;

    protected function setUp(): void
    {
        parent::setUp();

        $this->brand = new Brand();
    }

    public function testValidWhenMakeIsNotEmpty()
    {
        $data['brand'] = 'UnitBrand';
        self::assertTrue($this->brand->isValid($data));
    }

    public function testNotValidWhenMakeIsNotSet()
    {
        $data = [];
        self::assertFalse($this->brand->isValid($data));
    }

    public function testNotValidWhenMakeIsNotString()
    {
        $data['brand'] = 123;
        self::assertFalse($this->brand->isValid($data));
    }

    public function testNotValidWhenMakeHasOnlySpace()
    {
        $data['brand'] = '    ';
        self::assertFalse($this->brand->isValid($data));
    }
}
