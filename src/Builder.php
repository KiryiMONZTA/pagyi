<?php

namespace Kiryi\Pagyi;

use Kiryi\Pagyi\Model\Section;
use Kiryi\Pagyi\Helper\Initializer;
use Kiryi\Viewyi\Engine as Viewyi;

class Builder extends \Exception
{
    const ERRORMSG_CONFIGFILEDOESNOTEXIST = 'PAGYI CONFIGURATION ERROR: File "%s" does not exist!';
    const ERRORMSG_CONFIGFILEISBROKEN = 'PAGYI CONFIGURATION ERROR: File "%s" is broken!';
    const TEMPLATEDIR = 'vendor/kiryi/pagyi/src/View';
    const TEMPLATEFILEEXTENSION = '.tpl.php';
    const TEMPLATENAME_PAGE = 'page';
    const TEMPLATENAME_SECTION = 'section';

    private ?Initializer $initializer = null;
    private ?Viewyi $viewyi = null;
    
    public function __construct(string $baseUrl, string $imgPath, string $imgDir)
    {
        $this->initializer = Initializer::getInstance();
        $this->initializer->setBaseUrl($baseUrl);
        $this->initializer->setImgPath($imgPath);
        $this->initializer->setImgDir($imgDir);

        $this->viewyi = new Viewyi([
            'baseUrl' => $baseUrl,
            'imagePath' => $imgPath,
            'templateDirectory' => $this::TEMPLATEDIR,
            'templateFileExtension' => $this::TEMPLATEFILEEXTENSION,
        ]);
    }

    public function build(string $configFilepath, string $textDir): string
    {
        $this->initializer->setTextDir($textDir);
        $this->initializer->setConfigFilepath($configFilepath);

        $pageConfig = $this->readConfigFile($this->initializer->getConfigFilepath());
        
        return $this->renderPage($pageConfig);
    }

    private function renderPage(array $pageConfig): string
    {
        foreach ($pageConfig as $sectionConfig) {
            $page = $this->renderSection($sectionConfig);
        }
        
        $this->viewyi->reset();
        $this->viewyi->assign('page', $page);

        return $this->viewyi->render($this::TEMPLATENAME_PAGE);
    }

    private function renderSection(object $sectionConfig): string
    {
        $section = new Section($sectionConfig);

        foreach ($section->getProperties() as $key => $value) {
            $this->viewyi->assign($key, $value);
        }

        return $this->viewyi->render($this::TEMPLATENAME_SECTION);
    }

    private function readConfigFile(string $configFilepath): array
    {
        if (file_exists($configFilepath) === true) {
            if (null !== $pageConfig = json_decode(file_get_contents($configFilepath))) {
                return $pageConfig;
            } else {
                throw new \Exception(sprintf($this::ERRORMSG_CONFIGFILEISBROKEN, $configFilepath));
            }
        } else {
            throw new \Exception(sprintf($this::ERRORMSG_CONFIGFILEDOESNOTEXIST, $configFilepath));
        }
    }
}
