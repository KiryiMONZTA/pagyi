<?php

namespace Kiryi\Pagyi\Model;

use Kiryi\Pagyi\Helper\Initializer;
use Kiryi\Pathyi\Formatter as Pathyi;

class Text implements PropertyInterface
{
    private ?string $text = null;

    public function setProperty($value): void
    {
        $filepath = Initializer::getInstance()->getTextDir() . $value . '.md';

        if ($this->validateTextfile($filepath) === true) {
            $this->text = $this->setText($filepath);
        }
    }

    public function getProperty(): ?string
    {
        return $this->text;
    }

    private function validateTextfile(string $filepath): bool
    {
        if (file_exists($filepath) === true) {
            return true;
        } else {
            return false;
        }
    }

    private function setText(string $filepath): string
    {
        return (new \Parsedown())->text(file_get_contents($filepath));
    }
}
