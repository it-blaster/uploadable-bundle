# UploadableBundle

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/it-blaster/uploadable-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/it-blaster/uploadable-bundle/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/it-blaster/uploadable-bundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/it-blaster/uploadable-bundle/build-status/master)
[![License](https://poser.pugx.org/it-blaster/uploadable-bundle/license.svg)](https://packagist.org/packages/it-blaster/uploadable-bundle)
[![Total Downloads](https://poser.pugx.org/it-blaster/uploadable-bundle/downloads)](https://packagist.org/packages/it-blaster/uploadable-bundle)
[![Latest Unstable Version](https://poser.pugx.org/it-blaster/uploadable-bundle/v/unstable.svg)](https://packagist.org/packages/it-blaster/uploadable-bundle)
[![Latest Stable Version](https://poser.pugx.org/it-blaster/uploadable-bundle/v/stable.svg)](https://packagist.org/packages/it-blaster/uploadable-bundle)

The extended Symfony's Form File Type based on [it-blaster/uploadable-behavior](https://github.com/it-blaster/uploadable-behavior).

It provides the ability to easily upload files, show links to them and display checkbox-controls for deletion them
(only from database) in your forms.

## Installation

Add it-blaster/uploadable-bundle to your `composer.json` file and run `composer`

```json
...
"require": {
    "it-blaster/uploadable-behavior": "dev-master"
}
...
```

Register the bundle in your `AppKernel.php`

```php
...
new Fenrizbes\UploadableBundle\FenrizbesUploadableBundle(),
...
```

Configure [it-blaster/uploadable-behavior](https://github.com/it-blaster/uploadable-behavior)

## Usage

Now you can use the `uploadable` form type:

```php
...
    ->add('MyFile', 'uploadable')
...
```

This type inherits all the `file` type's options (except `constraints`) and has own ones:
- `removable` (boolean, default: true) - display or not the checkbox-control for deletion
- `remove_label` (string, default: 'remove') - the label for checkbox-control (if it's enabled)
- `file_constraints` (array, default: null) - constraints for the `file` field

## Configuration

The bundle has an only parameter `root_path` that determines the path to the project's root directory.
Default value is `%kernel.root_dir%/../web`. You can configure it as follows:

```yml
...
fenrizbes_uploadable:
    root_path: /your/own/path
...
```