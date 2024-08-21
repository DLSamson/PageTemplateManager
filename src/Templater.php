<?php

namespace PageTemplateManager;

use BadMethodCallException;
use Illuminate\Support\Str;
use PageTemplateManager\Traits\Singleton;
use PageTemplateManager\Exceptions\TemplateFileNotFoundException;
use function str_ends_with;

class Templater
{
    use Singleton;

    /**
     * @param string $templateDir   pathToFolder with all templates
     * @param mixed $varsToPass     variables to pass into template
     * @throws \InvalidArgumentException    config
     */
    public function __construct(string $templateDir, array $globalVariablesToPass = []) {
        $this->templateDir = str_ends_with($templateDir, '/') // If possible, we use polyfill
            ? substr($templateDir, 0, -1)
            : $templateDir;

        $this->globalVariablesToPass = $globalVariablesToPass;
    }

    protected string $templateDir;
    protected array $globalVariablesToPass = [];

    public function __call($name, $arguments) {
        $regex = '/load(?<type>.*?)Template/';
        
        if (!preg_match($regex, $name, $matches))
            throw new BadMethodCallException(sprintf('Method does not exsits or does not match pattern \'load{Type}Template\', found: %s', $name));

        if (count($arguments) > 2)
            throw new BadMethodCallException(sprintf('Expected exactly 0, 1 or 2 arguments, got %s', count($arguments)));

        if(isset($arguments[0]) && gettype($arguments[0]) !== 'string')
            throw new BadMethodCallException(sprintf('Expected argument 1 to be type "string", got %s', gettype($arguments[0])));

        if(isset($arguments[1]) && gettype($arguments[1]) !== 'array')
            throw new BadMethodCallException(sprintf('Expected argument 2 to be type "array", got %s', gettype($arguments[1])));

        $name = $arguments[0] ?? '';
        $values = $arguments[1] ?? [];
        $type = Str::camel($matches['type']);

        $this->loadTemplate($name, $type, $values);
    }
    
    public function loadTemplate(string $name, string $type, array $values = []) : void { // @TODO add tests with values

        $pathToTemplateFile = $name 
            ? sprintf('%s.%s.php', $this->parseName($name), $type)
            : sprintf('%s%s.php', $this->parseName($name), $type);

        if (!file_exists($pathToTemplateFile))
            throw new TemplateFileNotFoundException(sprintf('Template file with name %s and type %s not found at %s', $name ?: '*empty*', $type, $pathToTemplateFile));

        $this->includeTemplateFile($pathToTemplateFile, $values);
    }

    protected function parseName(string $name) : string {
        $pathParts = explode('.', $name);
        return $this->templateDir . '/' . implode('/', $pathParts);
    }
    
    protected function includeTemplateFile(string $file, array $values = []) {
        global $APPLICATION, $USER, $DB;

        (function (string $file, array $varsToPass, array $values) use ($APPLICATION, $USER, $DB) {
            extract($varsToPass);
            extract($values);
            require $file;
        })($file, $this->globalVariablesToPass, $values);
    }
}