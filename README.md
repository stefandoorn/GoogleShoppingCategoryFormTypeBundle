[![Build Status](https://travis-ci.org/stefandoorn/GoogleShoppingCategoryFormTypeBundle.svg?branch=master)](https://travis-ci.org/stefandoorn/GoogleShoppingCategoryFormTypeBundle)
[![Dependabot Status](https://api.dependabot.com/badges/status?host=github&repo=stefandoorn/GoogleShoppingCategoryFormTypeBundle)](https://dependabot.com)

# GoogleShoppingCategoryFormTypeBundle

## Installation

```bash
    composer require stefandoorn/google-shopping-category-form-type-bundle
``` 

## Usage

In your form, use:

```php
    $builder->add('googleShoppingCategory', GoogleShoppingCategoryType::class);
```

The locale of the category list downloaded can be adjusted by injecting another locale into the downloader service:

```yaml
    google_shopping_category.downloader.category:
        class: StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Downloader\GoogleShoppingCategoryList
        arguments:
            - 'nl_NL'
```
