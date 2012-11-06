# Magento - Force Store Code extension

## Overview
Activate "Add Store Code to Urls" in Magento backend and you will see that your main URL remains available, even without store code.

This extension checks, only on the home page, if the store code is in URL. If it is not, the extension redirects (301) to "base URL + current website's default store view code".

This extensions does not manage internal pages, only home page, because for them, Magento automatically adds store code in URL.

## Compatibility
Tested on Magento CE 1.6.2.0 and 1.7.0.2

## Notes
* Free and open source
* Fully configurable
* Bundled with English and French translations

## Installation
Just download the "app" folder and paste it into the root directory of your Magento application. It will be merged with the existing "app" folder.

No Magento files will be modified or extended.

## Usage
In __System > Configuration > General > Web > Url Options__, this extension adds a new option: __Force Store Code in Urls__

![](http://2.bp.blogspot.com/-8tgBLWnMPTQ/UG2KY6QwwnI/AAAAAAAALKc/_mUbwp1CRf0/s1600/force-store-code.png)
* Select "No" to stay with the Magento basic behavior
* Select "Yes" to activate the extension

Note: HTTP redirection may be cached by your browser if you had previously activated the extension so clean your cache after selecting "No" if redirection keeps being done.

## Changelog
### 1.0
* initial release
