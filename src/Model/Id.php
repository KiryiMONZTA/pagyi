<?php

namespace Kiryi\Pagyi\Model;

class Id implements PropertyInterface
{
    private ?string $id = null;

    public function setProperty($value): void
    {
        if ($this->validateId($value) === true) {
            $this->id = $value;
        }
    }
    
    public function getProperty(): ?string
    {
        return $this->id;
    }

    private function validateId(string $id): bool
    {
        if (
            preg_match('/-?[_a-zA-Z]+[_a-zA-Z0-9-]*/', $id, $matches) === 1
            && $matches[0] == $id
        ) {
            return true;
        } else {
            return false;
        }
    }
}
