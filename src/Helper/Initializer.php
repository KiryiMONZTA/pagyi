<?php

namespace Kiryi\Pagyi\Helper;

use Kiryi\Pathyi\Formatter as Pathyi;
use Kiryi\Inyi\Reader as Inyi;

class Initializer
{
    const ROOTDIR = __DIR__ . '/../../../../../';
    const CONFIGFILE_SECTION_PAGYI = 'pagyi::';
    const CONFIGFILE_SECTION_VIEWYI = 'viewyi::';
    const CONFIGFILE_PARAMS = ['baseUrl', 'imagePath', 'imageDirectory'];

    private string $baseUrl = '';
    private string $imgPath = '';
    private string $imgDir = '';
    private string $buildConfigFilepath = '';
    private string $textDir = '';

    private static ?Initializer $instance = null;
    private ?Pathyi $pathyi = null;

    private function __construct()
    {
        $this->pathyi = new Pathyi();
    }

    public static function getInstance(): Initializer
    {
        if (self::$instance === null) {
            self::$instance = new Initializer();
        }

        return self::$instance;
    }

    public function initByConfigFile(?string $filepath): void
    {
        if ($filepath !== null) {
            $inyi = new Inyi($filepath);
            $params = [];
    
            foreach ($this::CONFIGFILE_PARAMS as $param) {
                try {
                    $params[$param] = $inyi->get($this::CONFIGFILE_SECTION_PAGYI . $param);
                } catch (\Exception $e) {
                    try {
                        $params[$param] = $inyi->get($this::CONFIGFILE_SECTION_VIEWYI . $param);
                    } catch (\Exception $e) {
                        $params[$param] = '';
                    }
                }
            }
    
            foreach ($params as $param => $value) {
                if ($value !== '') {
                    switch ($param) {
                        case 'baseUrl':
                            $this->setBaseUrl($value);
                            break;
                        case 'imagePath':
                            $this->setImgPath($value);
                            break;
                        case 'imageDirectory':
                            $this->setImgDir($value);
                            break;
                    }
                }
            }
        }
    }

    public function setBaseUrl($baseUrl): void
    {
        if ($baseUrl !== null) {
            $this->baseUrl = $this->pathyi->format($baseUrl, false, true);
        }
    }

    public function setImgPath($imgPath): void
    {
        if ($imgPath !== null) {
            $this->imgPath = $this->baseUrl . $this->pathyi->format($imgPath, false, true);
        }
    }

    public function setImgDir($imgDir): void
    {
        if ($imgDir !== null) {
            $this->imgDir = $this::ROOTDIR . $this->pathyi->format($imgDir, false, true);
        }
    }

    public function setBuildConfigFilepath($buildConfigFilepath): void
    {
        $this->buildConfigFilepath = $this::ROOTDIR . $this->pathyi->format($buildConfigFilepath);
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

    public function getBuildConfigFilepath(): string
    {
        return $this->buildConfigFilepath;
    }

    public function getTextDir(): string
    {
        return $this->textDir;
    }
}
