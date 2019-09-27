# Foxy Yii2 Convert

covert Yii2 `npm-asset` or `bower-asset` to `package.json`, so that [Foxy](https://github.com/fxpio/foxy) can install.

# install

```bash
composer require kriss/foxy-yii2-convert -vvv
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

# FAQ

> Q: If one package I dont want to install view npm?

A: Like [almasaeed2010/adminlte](https://github.com/almasaeed2010/adminlte), it can be installed by composer, you can config this in composer.json like:

```json
  "config": {
    "foxy": {
      "enabled": true,
      "manager": "yarn",
      "enable-packages": {
        "almasaeed2010/adminlte": false, // this tip
        "*": true // this must be add in last
      }
    }
  },
```

> Q: If one package has `package.json`,and just use for develop?

A: Like [kartik-v/dependent-dropdown](https://github.com/kartik-v/dependent-dropdown), you can config this in composer.json like:

```json
  "config": {
    "foxy": {
      "enabled": true,
      "manager": "yarn",
      "enable-packages": {
        "kartik-v/dependent-dropdown": false, // this tip
        "*": true // this must be add in last
      }
    }
  },
```

> Q: If one package is dont have same npm package name in bower?

A: Tell me with a issue.
