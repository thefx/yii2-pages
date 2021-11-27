Pages
======
Pages

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require thefx/yii2-pages:dev-master
```

or add

```
"thefx/yii2-pages": "dev-master"
```

to the require section of your `composer.json` file.

Alternative installation
---

1. Move libs to extensions/thefx/yii2-blocks
2. Then add to your config

```
'aliases' => [
    '@thefx/pages' => '@app/extensions/thefx/yii2-pages',
    ...
],
```

Configuration
---

Modify your application configuration:

```
return [
    'modules' => [
        'pages' => [
            'class' => 'thefx\pages\Module',
            'layout' => 'main',
            'layoutPure' => 'pure',
            'layoutPath' => '@app/modules/admin/layouts',
        ...
        ]
        ...
    ],
];
```

Add to routes if you want to urls begin with admin/

```
'admin/<_m:(pages)>' => '<_m>/default/index',
'admin/<_m:(pages)>/<id:\d+>' => '<_m>/<_c>/view',
'admin/<_m:(pages)>/<_a:[\w-]+>/<id:\d+>' => '<_m>/default/<_a>',
'admin/<_m:(pages)>/<_a:[\w-]+>' => '<_m>/default/<_a>',
```

Apply Migrations

```
php yii migrate --migrationPath=@thefx/pages/migrations
```

Usage
-----

Go and create page

```
http://site.com/admin/pages
http://site.com/pages/default/index
```
