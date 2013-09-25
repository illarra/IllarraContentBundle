Illarra Content Bundle
======================

[![Build Status](https://secure.travis-ci.org/illarra/IllarraContentBundle.png)](http://travis-ci.org/illarra/IllarraContentBundle) [![Total Downloads](https://poser.pugx.org/illarra/content-bundle/d/total.png)](https://packagist.org/packages/illarra/content-bundle) [![Latest Stable Version](https://poser.pugx.org/illarra/content-bundle/version.png)](https://packagist.org/packages/illarra/content-bundle) [![Latest Unstable Version](https://poser.pugx.org/illarra/content-bundle/v/unstable.png)](https://packagist.org/packages/illarra/content-bundle)

Installation
------------

Add this bundle (and its dependencies, if they are not already there) to your application's kernel:

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new JMS\DiExtraBundle\JMSDiExtraBundle($this),
        new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
        new Liip\ImagineBundle\LiipImagineBundle(),
        new Illarra\ContentBundle\IllarraContentBundle(),
        // ...
    );
}
```
