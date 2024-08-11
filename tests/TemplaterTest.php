<?php declare(strict_types=1);

use PageTemplateManager\Exceptions\SingletonPatternIsNotSet;
use PageTemplateManager\Templater;
use PHPUnit\Framework\TestCase;

final class TemplaterTest extends TestCase {
    public function testCanIncludeTemplateFromObject() : void {
        $templatesDirectory = __DIR__ . '/templates';

        $templater = new Templater($templatesDirectory);
        
        ob_start();
        $templater->loadHeaderTemplate('test');
        $content = ob_get_clean();
        $this->assertEquals('headerTemplate', $content);

        ob_start();
        $templater->loadFooterTemplate('test');
        $content = ob_get_clean();
        $this->assertEquals('footerTemplate', $content);
    }

    public function testCanIncludeTemplateFromSingleton() : void {
        $templatesDirectory = __DIR__ . '/templates';

        Templater::enableSingletonPattern($templatesDirectory);
        
        ob_start();
        Templater::loadHeaderTemplate('test');
        $content = ob_get_clean();
        $this->assertEquals('headerTemplate', $content);

        ob_start();
        Templater::loadFooterTemplate('test');
        $content = ob_get_clean();
        $this->assertEquals('footerTemplate', $content);

        Templater::disableSingletonPattern();
    }

    public function testCanIncludeTemplateInSubDirectory() : void {
        $templatesDirectory = __DIR__ . '/templates';

        $templater = new Templater($templatesDirectory);
        
        ob_start();
        $templater->loadHeaderTemplate('subdirectory.test');
        $content = ob_get_clean();
        $this->assertEquals('headerTemplate', $content);

        ob_start();
        $templater->loadFooterTemplate('subdirectory.test');
        $content = ob_get_clean();
        $this->assertEquals('footerTemplate', $content);
    }

    public function testCanAccessObjectFromTemplate() : void {
        $templatesDirectory = __DIR__ . '/templates';

        $object = new stdClass;
        $object->value = 'objectValue';

        $varsToPass = [
            'object' => $object
        ];

        $templater = new Templater($templatesDirectory, $varsToPass);

        ob_start();
        $templater->loadObjectTemplate('test');
        $content = ob_get_clean();
        $this->assertEquals($object->value, $content);
    }

    public function testCanIncludeZeroArgumentsTemplate() : void {
        $templatesDirectory = __DIR__ . '/templates';

        $templater = new Templater($templatesDirectory);

        ob_start();
        $templater->loadZeroArgumentsTemplate();
        $content = ob_get_clean();
        $this->assertEquals('zero', $content);
    }

    public function testAccessToSingletonWithoutInitialization() : void {
        $this->expectException(SingletonPatternIsNotSet::class);
        $this->expectExceptionMessage(sprintf('Enable singelton patter via %s::enableSingletonPattern() method', Templater::class));

        Templater::loadWhateverWithoutSingletonTemplate();
    }
}