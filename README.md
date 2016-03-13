twig-hashed-file-extension
==========================

The [grunt-hash](https://www.npmjs.org/package/grunt-hash) [grunt](http://www.gruntjs.com/) plugin allows you to rename files according to their content.

The [robo-hash](https://github.com/agallou/robo-hash) task allows you to to the same in PHP.
 
For example a file named `main.css` will be renamed to `main.54e79f6f.css`.

So the file is not easy to include in a Twig template (its name will change at every content change).

This plugin adds a twig function called `hashed_file`.


Usage
-----

You can call it like this :

```php
$twig->addExtension(new \Agallou\TwigHashedFileExtension\Extension(__DIR__ . '/web/assets/', null));
```


```twig
<link rel="stylesheet" href="{{ hashed_file('css/main.css') }}" />
```

It will look for files called `main*.css` in the `web/assets/css` directory and serve it as `/assets/main.54e79f6f.css`.

If no file is found or more than one file is found an exception will be thrown.
