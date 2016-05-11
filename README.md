BaseBundle
=======================
Symfony Bundle which contains common project functionality.

## Installing BaseBundle

The recommended way to install BaseBundle is through
[Composer](http://getcomposer.org).

Add these lines to your `composer.json` file.
```javascript
// composer.json

{
    // ...
    "repositories" : [{
        "type" : "vcs",
        "url" : "https://github.com/velygotsky/BaseBundle.git"
    }],
    
    // ...
}
```

Next, run the Composer command to install the latest stable version of BaseBundle:

```bash
php composer.phar require "velygotsky/basebundle"
```
Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Velygotsky\BaseBundle\BaseBundle(),
        );

        // ...
    }

    // ...
}
```
