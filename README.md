# PageTemplateManager

It is a convenient package for Bitrix CMS that allows developers to easily create and manage page templates inside a single website template. 
With this tool, you can quickly develop reusable templates that can be used for various pages inside one site template of your web application.

## What problem this package is trying to solve?

Page Template Manager is designed to solve the problem of the lack of a built-in mechanism in Bitrix for defining different types of pages within a single template. Because of this, developers have to perform a lot of if-else checks both in the code and in the site configuration to determine the current page and connect the appropriate template, which leads to cumbersome and difficult to maintain code. 

The package offers a simple solution — the ability to specify the URLs of the pages and their corresponding templates in the configuration. PageTemplateManager automatically detects the current page and connects the desired template, eliminating the need to write a lot of if-else checks and making the code cleaner and more modular.

> Setting up a config with urls is in development stage.
> 
> When it will be ready and well tested, I will commit this package to a packagist.org

## Examples

### Basic use

The PageTemplateManager package provides a simple and intuitive API for managing page templates. 
The main class you'll interact with is the Templater class, which can be used either as an object or via a singleton pattern.

To start using the package, first include the autoloader in your PHP script:

```php
require_once 'pathToVendor/autoload.php';

use PageTemplateManager\Templater;
```

Next, specify the directory where your page templates are located:
```php
$templateDir = 'pathToYourPageTemplatesFolder';
```

#### Using the Templater as an Object
Create an instance of the Templater class and pass the template directory path:

```php
$templater = new Templater($templateDir);
```

You can then load the header and footer templates for your pages:

```php
$templater->loadHeaderTemplate('content');
$templater->loadFooterTemplate('content');
```

The `loadHeaderTemplate` and `loadFooterTemplate` methods expect the base name of the template files (without the .php extension). 
For example, if your header template is named content.header.php, you would pass 'content' as the argument.

#### Using the Singleton Pattern
Alternatively, you can use the Templater class via the singleton pattern:

```php
Templater::enableSingletonPattern($templateDir);

Templater::loadHeaderTemplate('content');
Templater::loadFooterTemplate('content');
```

This allows you to access the Templater methods statically without creating an instance.

If you want to disable the singleton pattern after enabling it, you can use the disableSingletonPattern method:
```php
Templater::disableSingletonPattern();
```

The package assumes that your template files are named using the following convention:

```text
templateDir
|
|-content.header.php <-- These will be included
|-content.footer.php <--
```

The base name of the template file (e.g., 'content') is used to locate the corresponding header and footer templates in the specified directory.

By following these basic usage guidelines, you can quickly start managing page templates using the PageTemplateManager package in your Bitrix project.

### Subdirectory use

You can create as many subfolders as you want, just separate name with dots

```php
Templater::loadHeaderTemplate('services.list');
Templater::loadSidebarTemplate('services.list');
Templater::loadFooterTemplate('services.list');

/**
 * templateDir
 * |-services
 * | |-list.header.php  <-- These will be included
 * | |-list.sidebar.php <--
 * | |-list.footer.php  <--
 * |
 * |-content.header.php
 * |-content.footer.php
 */ 
```

### Your Own Template Types

While you follow `load{Type}Template` pattern when calling a method, you can name your type however you want.

```php
Templater::loadSubFooterTemplate('list');
Templater::loadWhatEverTemplate('content');

/**
 * templateDir
 * |
 * |-list.subFooter.php     <-- This will be included
 * |-content.whatEver.php   <--
 * |
 * |-services
 * | |-list.header.php
 * | |-list.sidebar.php
 * | |-list.footer.php
 * |
 * |-content.header.php
 * |-content.footer.php
 */ 
```

### Basic Templates

If you don't want to specify a name, you mustn't do it.
> But it only works without subdirectories

```php
Templater::loadHeaderTemplate();
Templater::loadFooterTemplate();

/**
 * templateDir
 * |
 * |-header.php <-- These will be included
 * |-footer.php <--
 */ 
```

## TODO

- [ ] Implement Manager class to make it understand which template should load, depending on a page url
- [ ] Add Real-use examples
- [ ] Submit a package to packagist
- [ ] Create a docs page on githubpages
- [ ] Make basic templates without names work in subdirectories
- [ ] Add translation for Russian Language
- [ ] Make a cli command to easily generate new templates. - If it is in demand

## Real Use Example

// @TODO add real use examples
