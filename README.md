# A Laravel Nova tool for testing redirects

This is a laravel nova tool, where you can test visually if all your redirects are working as expected. 

![Animate](https://user-images.githubusercontent.com/642292/93993236-c9bcd300-fd8e-11ea-8400-9db1f3251d59.gif)

## Table of content
1. [Why should I use this package?](#why-should-i-use-this-package)
2. [Installation](#installation)
3. [Create tests](#create-tests)
4. [Editing Groups](#editing-groups)
5. [Examples](#examples)

## Why should I use this package?

If you have a lot of old urls you have redirected to new ones (for example you changed the url structure, migrated to laravel or introduced new language specific urls) and you are using Laravel Nova, then this package can help you have an eye on these redirects.

This is especially important to keep your visitors and SEO power by preventing broken redirects.

## Installation

You can install the package in to a Laravel app that uses Nova via composer:

```
composer require bernhardh/nova-redirect-tester
```

After that, run the builtin migrations, which will create 2 tables:

- `nova_redirect_tester`: This are the tests
- `nova_redirect_tester_groups`: With this, you can group your tests

```
php artisan migrate
```

Now you must register the tool with Nova. This is done in the tools method of the `NovaServiceProvider`.

```php
// file app/Providers/NovaServiceProvider.php

public function tools()
{
    return [
        // ...
        \Bernhardh\NovaRedirectTester\NovaRedirectTester::make()
    ];
}
```

Now you will find the Redirect Tester menu entry in your Nova sidebar. Right now, there are no tests, please read on to find out, how to create new tests.

## Create tests

You can either fill up the two database tables `nova_redirect_tester` and `nova_redirect_tester_groups` by yourself (for example with phpmyadmin) or you use Nova to manage this. The easiest way to to this, is to create the two Nova resources, by extending the package nova resources:

```php
<?php
// File app/Nova/RedirectTestGroup

namespace App\Nova;

class RedirectTestGroup extends \Bernhardh\NovaRedirectTester\Nova\RedirectTestGroup {}
```

```php
<?php
// File app/Nova/RedirectTest

namespace App\Nova;

class RedirectTest extends \Bernhardh\NovaRedirectTester\Nova\RedirectTest {}
```

Now you can add a new test like any other nova resource. 

## Editing Groups

The Group resource is hidden by default in your sidebar. You can change that, by adding `public static $displayInNavigation = true;` to your `App\Nova\RedirectTestGroup` class.

## Examples

If you wanna try it out, just add the following routes to your `routes/web.php`:

```php
// routes/web.php
Route::get('cms/categories/articles/{article}.htm', function($article){
    return redirect('articles/' . $article);
});
Route::get('static-site/{article}.html', function($article){
    return redirect('articles/' . $article);
});
Route::get('articles/{article}', function($article){
    return '<h1>' . $article . '</h1>';
});
```

and then add the following `Redirect Tests` in nova:

| Group  | Status Code  | Url From  | Url To  |
|---|---|---|---|
| Articles  | 301  | /cms/categories/articles/my-first-article.htm  | /articles/my-first-article  |
| Articles  | 301  | /cms/categories/articles/the-2-article.htm  | /articles/the-2-article  |
| Articles  | 301  | /static-site/prices  | /articles/prices  |
| Default  | 404  | /this-url-does-not-exist  | |
| Default  | 301  | /my-old-url  | /this-test-will-fail |

This will result in the following:

![image](https://user-images.githubusercontent.com/642292/93991705-de986700-fd8c-11ea-9631-c4d135595412.png)
