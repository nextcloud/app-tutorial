# NOTICE: This tutorial has been DEPRECATED

This tutorial has been deprecated and displayed here for archival reasons, only.

Please, head to [the new app tutorial](https://cloud.nextcloud.com/s/iyNGp8ryWxc7Efa?path=%2F) if you wish to get started developing Nextcloud apps!

------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------

# Nextcloud App Tutorial

[![PHPUnit GitHub Action](https://github.com/nextcloud/app-tutorial/workflows/PHPUnit/badge.svg)](https://github.com/nextcloud/app-tutorial/actions?query=workflow%3APHPUnit)
[![Node GitHub Action](https://github.com/nextcloud/app-tutorial/workflows/Node/badge.svg)](https://github.com/nextcloud/app-tutorial/actions?query=workflow%3ANode)
[![Lint GitHub Action](https://github.com/nextcloud/app-tutorial/workflows/Lint/badge.svg)](https://github.com/nextcloud/app-tutorial/actions?query=workflow%3ALint)

This is a tutorial app which shows how to develop a very simple notes app.
 
## Try it 
To install it change into your Nextcloud's apps directory:

    cd nextcloud/apps

Then clone this repository into a folder named **notestutorial**¹:

    git clone https://github.com/nextcloud/app-tutorial.git notestutorial

Then install the dependencies using:

    make composer

¹ It is important that the directory is named exactly like the app ID (see `appinfo/info.xml`).

## Frontend development

The app tutorial also shows the very basic implementation of an app frontend using [Vue.js](https://vuejs.org/). To build the frontend code after doing changes to its source in `src/` requires to have Node and npm installed.

- 👩‍💻 Run `make dev-setup` to install the frontend dependencies
- 🏗 To build the Javascript whenever you make changes, run `make build-js`

To continuously run the build when editing source files you can make use of the `make watch-js` command.
