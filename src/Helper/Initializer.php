<?php

namespace Kiryi\Pagyi\Helper;

use Kiryi\Pathyi\Formatter as Pathyi;

class Initializer
{
    const ROOTDIR = __DIR__ . '/../../../../../';

    private string $baseUrl = '';
    private string $imgPath = '';
    private string $imgDir = '';
    private string $configFilepath = '';
    private string $textDir = '';

    private static $instance = null;
    private ?Pathyi $pathyi = null;

    private function __construct()
    {
        $this->pathyi = new Pathyi();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Initializer();
        }

        return self::$instance;
    }

    public function setBaseUrl($baseUrl): void
    {
        $this->baseUrl = $this->pathyi->format($baseUrl, false, true);
    }

    public function setImgPath($imgPath): void
    {
        $this->imgPath = $this->baseUrl . $this->pathyi->format($imgPath, false, true);
    }

    public function setImgDir($imgDir): void
    {
        $this->imgDir = $this::ROOTDIR . $this->pathyi->format($imgDir, false, true);
    }

    public function setConfigFilepath($configFilepath): void
    {
        $this->configFilepath = $this::ROOTDIR . $this->pathyi->format($configFilepath);
    }

    public function setTextDir($textDir): void
    {
        $this->textDir = $this::ROOTDIR . $this->pathyi->format($textDir, false, true);
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getImgPath(): string
    {
        return $this->imgPath;
    }

    public function getImgDir(): string
    {
        return $this->imgDir;
    }

    public function getConfigFilepath(): string
    {
        return $this->configFilepath;
    }

    public function getTextDir(): string
    {
        return $this->textDir;
    }
}
