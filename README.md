yii2-daterangepicker
==================
yii2 daterangepicker extension

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist aprsoft/yii2-daterangepicker "*"
```

or add

```
"aprsoft/yii2-daterangepicker": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \AprSoft\DateRangePicker\DateRangePicker::widget(); ?>
```
or    
```php
<?= $form->field($model, 'body')->widget(\AprSoft\DateRangePicker\DateRangePicker::className()) ?>
```

