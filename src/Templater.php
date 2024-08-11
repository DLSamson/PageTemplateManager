<?php

namespace PageTemplateManager;

use BadMethodCallException;
use Illuminate\Support\Str;
use PageTemplateManager\Traits\Singleton;
use PageTemplateManager\Exceptions\TemplateFileNotFoundException;

class Templater
{
    use Singleton;

    /**
     * @param string $templateDir   pathToFolder with all templates
     * @param mixed $config         pages/templates configuration
     * @param mixed $varsToPass     variables to pass into template
     * @throws \InvalidArgumentException    config
     */
    public function __construct(string $templateDir, $varsToPass = []) {
        $this->templateDir = str_ends_with($templateDir, '/')
            ? substr($templateDir, 0, -1)
            : $templateDir;

        $this->varsToPass = $varsToPass;
    }

    protected string $templateDir;
    protected array $varsToPass = [];

    public function __call($name, $arguments) {
        $regex = '/load(?<type>.*?)Template/';
        
        if (!preg_match($regex, $name, $matches))
            throw new BadMethodCallException(sprintf('Method does not exsits or does not match pattern \'load{Type}Template\', found: %s', $name));

        if (count($arguments) > 1)
            throw new BadMethodCallException(sprintf('Expected exactly 0 or 1 arguments, got %s', count($arguments)));

        $name = $arguments[0] ?? '';
        $type = Str::camel($matches['type']);

        $this->loadTemplate($name, $type);
    }
    
    public function loadTemplate(string $name, string $type) : void {

        $pathToTemplateFile = $name 
            ? sprintf('%s.%s.php', $this->parseName($name), $type)
            : sprintf('%s%s.php', $this->parseName($name), $type);

        if (!file_exists($pathToTemplateFile))
            throw new TemplateFileNotFoundException(sprintf('Template file not found at %s', $pathToTemplateFile));

        $this->includeTemplateFile($pathToTemplateFile);
    }

    protected function parseName(string $name) : string {
        $pathParts = explode('.', $name);
        return $this->templateDir . '/' . implode('/', $pathParts);
    }
    
    protected function includeTemplateFile($file) {
        global $APPLICATION, $USER, $DB;

        (function ($file, $varsToPass) use ($APPLICATION, $USER, $DB) {
            extract($varsToPass);
            require $file;
        })($file, $this->varsToPass);
    }
}