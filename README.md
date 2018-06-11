# yii2-rest-api-captcha
Simple captcha image generator for restful api

## Installation

Recommended installation via [composer](http://getcomposer.org/download/):

```
composer require venomousboy/yii2-rest-api-captcha
```

## Usage

Generate captcha code (image/png;base64):

```php
(new CaptchaHelper())->generateImage();
```

Use in HTML:

```html
<img src="<?= (new CaptchaHelper())->generateImage() ?>" />
```
Verify POST method captcha code:

```php
(new CaptchaHelper())->verify(\Yii::$app->request->post('code'));
```
