<?php declare(strict_types=1);

namespace App\Tests\Unit\Service\Validator;

use App\Service\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function test()
    {
        $validator = new Validator();

        $data =   [
            "brand" => "Audi",
            "model" => "A8",
            "desc" => "dictumst morbi vestibulum"
        ];

        self::assertTrue($validator->isValid($data));
    }
}
