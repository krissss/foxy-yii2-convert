# Foxy Yii2 Convert

covert Yii2 `npm-asset` or `bower-asset` to `package.json`, so that [Foxy](https://github.com/fxpio/foxy) can install.

# install

```bash
composer require kriss/foxy-yii2-convert -vvv
```

# usage

[English](README.md)

1. 在 `composer.json` 中增加 `provide` 以跳过安装 `npm-asset` or `bower-asset`

如下:

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

2. 如果你项目中使用 [composer-asset-plugin](https://github.com/fxpio/composer-asset-plugin) 或者 [asset-packagist](https://github.com/hiqdev/asset-packagist)，请移除

3. 安装依赖

4. 修改 Yii2 的 npm 和 bower 别名指向

如下：

```php
'aliases' => [
    '@bower' => '@project/node_modules',
    '@npm' => '@project/node_modules',
],
```

# FAQ

> Q: 如果有个包我不想通过 npm 安装？

A: 像 [almasaeed2010/adminlte](https://github.com/almasaeed2010/adminlte), 它可以用 composer 安装, 可以配置 composer.json 如下:

```bash
  "config": {
    "foxy": {
      "enabled": true,
      "manager": "yarn",
      "enable-packages": {
        "almasaeed2010/adminlte": false, // 此处
        "*": true // 确保这个放在最后
      }
    }
  },
```

> Q: 如果一个包内自带 `package.json`，并且仅仅是用于开发环境（即我不需要它）?

A: 像 [kartik-v/dependent-dropdown](https://github.com/kartik-v/dependent-dropdown), 可以配置 composer.json 如下:

```bash
  "config": {
    "foxy": {
      "enabled": true,
      "manager": "yarn",
      "enable-packages": {
        "kartik-v/dependent-dropdown": false, // 此处
        "*": true // 确保这个放在最后
      }
    }
  },
```

> Q: 如果一个包在 npm 中和 brower 中非一致的名字?

A: 请通过 issue 告诉我.
