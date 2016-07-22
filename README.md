# yii2-translation-gui
Yii2 translation GUI for better management on translation messages while developing.

Features
--------
- Provides a web-based graphical user interface for message translations in YII2
- Supports multiple languages and categories
- Uses only a single database table
- Can generate YII2 standard translation files with one click
- Command-line interface to import existing translation files(if any)

Installation
------------

### Install With Composer

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

```
php composer.phar require amdz/yii2-translation-gui "dev-master"

```
Or, you may add

```
"amdz/yii2-translation-gui": "dev-master"
```

to the require section of your `composer.json` file and execute `php composer.phar update`.

Configuration
-------------
Once the extension is installed, simply add the extention to your 'module' section of your application configuration file. Do not forget to add required configuration params as follow:
```php
return [
    'modules' => [
        'translator' => [
            'class' => 'amdz\yii2Translator\Module',
            'languages' => [
                'en-US' => 'English',
                'fa-IR' => 'Farsi',
                //'de-GE' => 'German',
            ],
            'categories' => [
                'app' => 'Application',
            ],
            'defaultLanguage' => 'en-US',
            'defaultCategory' => 'app',
            'messagePath' => '@app/messages', //optional
        ],
        ]
        ...
    ],
];
```

Migrations
---------------------------
To create the translation database table, execute the following migration:
```
yii migrate --migrationPath=@amdz/yii2Translator/migrations
```

Importing existing translation files(if any)
--------------------------------------------
This extension provides a command interface to import existing Yii2 standard translation files into database(if any).
Run the following command to import files:
```
>>> yii translator/import/standard @app/path/to/message/directory
```
or simple run:
```
>>> yii translator
```
for more instructions.
