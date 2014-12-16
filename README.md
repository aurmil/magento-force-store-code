# Magento - Force Store Code extension

## Overview

Activating "Add Store Code to Urls" in Magento back office will let your main URL available, even without store code.

This extension checks, only for the home page, if the store code is in URL. If it is not, it redirects (301) to "base URL + current website's default store view code".

This extensions does only manage home page, not internal pages, because for them, Magento automatically adds store code in URL.

## Compatibility

Tested on Magento CE 1.6 - 1.9

## Notes

* Free and open source
* Fully configurable
* Bundled with English and French translations

## Installation

No Magento files will be modified, no extended class, no overridden method.

### Manually

* Download the latest version of this module [here](https://github.com/aurmil/magento-force-store-code/archive/master.zip)
* Unzip it
* Move the "app" folder into the root directory of your Magento application, it will be merged with the existing "app" folder

### With modman

* ```$ modman clone git@github.com:aurmil/magento-force-store-code.git```

### With composer

* Adapt the following "composer.json" file into yours:

```
{
	"require": {
		"aurmil/magento-force-store-code": "dev-master"
	},
    "repositories": [
        {
            "type": "composer",
            "url": "http://packages.firegento.com"
        },
        {
            "type": "vcs",
            "url": "git://github.com/aurmil/magento-force-store-code"
        }
    ],
	"extra": {
		"magento-root-dir": "./"
	}
}
```

* Install or update your composer project dependencies

## Usage

In __System > Configuration > General > Web > Url Options__, this extension adds a new option: __Force Store Code in Urls__

![](http://2.bp.blogspot.com/-8tgBLWnMPTQ/UG2KY6QwwnI/AAAAAAAALKc/_mUbwp1CRf0/s1600/force-store-code.png)

* Select "No" to stay with the Magento basic behavior
* Select "Yes" (default value) to activate the extension

Note: HTTP redirection may be cached by your browser if you had previously activated the extension so clean your cache after selecting "No" if redirection keeps being done.

## Changelog

### 1.2

* Display option only when "Add store code to URLs" is set to "Yes".

### 1.1

* minor changes (code, lines length, comments, readme)

### 1.0

* initial release
