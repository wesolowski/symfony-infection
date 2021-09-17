<?php declare(strict_types=1);

namespace App\Service\Validator\Collection;

class Brand implements CheckInterface
{
    public function isValid(array $data): bool
    {
        return isset($data['brand']) && is_string($data['brand']) && trim($data['brand']) !== '';
    }
}
