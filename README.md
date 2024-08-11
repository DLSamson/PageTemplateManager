# PageTemplateManager

It is a convenient package for Bitrix CMS that allows developers to easily create and manage page templates inside a single website template. 
With this tool, you can quickly develop reusable templates that can be used for various pages inside one site template of your web application.

## Examples

### Basic use

Templater class can be used as an object or via singleton pattern;

```php
<?php
require_once 'pathToVendor/autoload.php';

use PageTemplateManager\Templater;

// Object use
$templateDir = 'pathToYourPageTemplatesFolder';

$templater = new Templater($templateDir);

$templater->loadHeaderTemplate('content');
$templater->loadFooterTemplate('content');

// Singleton use
$templateDir = 'pathToYourPageTemplatesFolder';

Templater::enableSingletonPattern($templateDir);

Templater::loadHeaderTemplate('content');
Templater::loadFooterTemplate('content');

/**
 * templateDir
 * |
 * |-content.header.php <-- These will be included
 * |-content.footer.php <--
 */ 
```

In case you want to disable singleton pattern after enabling it, you can use this method:
```php
Templater::disableSingletonPatter();
```

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

While you follow `load{Type}Template` patter when calling a method, you can name your type however you want.

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
But it only works without subdirectories

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
- [ ] Submit a package to packagist
- [ ] Create a docs page on githubpages
- [ ] Add translation for Russian Language
