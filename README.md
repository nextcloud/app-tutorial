# Tutorial

[![Build Status](https://travis-ci.org/nextcloud/app-tutorial.svg?branch=master)](https://travis-ci.org/nextcloud/app-tutorial)

This is the [tutorial](https://docs.nextcloud.com/server/14/developer_manual/app/startapp.html) app. To install it change into your Nextcloud's apps directory:

    cd nextcloud/apps

Then run:

    git clone https://github.com/nextcloud/app-tutorial.git notestutorial

where the branch parameter is the ownCloud version that you are targeting:

* Nextcloud 12: stable12
* Nextcloud master: master

Then install the dependencies using:

    composer install

**Important**: The tutorial requires PHP 7.1 due to type hinting. You may need to remove them for PHP versions lower than 7.1 and 7.0

## Using the Makefile

The following make targets are available:

* **test**: runs all tests
* **appstore**: builds the package that can be uploaded to the app store
* **source**: builds the source package
