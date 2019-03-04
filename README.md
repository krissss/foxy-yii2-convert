# Foxy Yii2 Convert

covert Yii2 `npm-asset` or `bower-asset` to `package.json`, so that [Foxy](https://github.com/fxpio/foxy) can install.

# install

```bash
composer require kriss/foxy-yii2-convert:dev-master
```

# usage

1. add `provide` to `composer.json` to skip install `npm-asset` or `bower-asset`

like this:

```json
{
    "provide": {
        "bower-asset/bootstrap": "*",
        "bower-asset/jquery": "*",
        "bower-asset/inputmask": "*",
        "bower-asset/punycode": "*",
        "bower-asset/yii2-pjax": "*",
        "npm-asset/wangeditor": "*",
        "npm-asset/webuploader": "*",
        "bower-asset/typeahead.js": "*"
  },
}
```

2. remove [composer-asset-plugin](https://github.com/fxpio/composer-asset-plugin) or [asset-packagist](https://github.com/hiqdev/asset-packagist) if you used in project

3. composer install

4. chage Yii2 npm and bower aliase

like this

```php
'aliases' => [
    '@bower' => '@project/node_modules',
    '@npm' => '@project/node_modules',
],
```