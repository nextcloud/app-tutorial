# Nextcloud App Tutorial

[![Build Status](https://travis-ci.org/nextcloud/app-tutorial.svg?branch=master)](https://travis-ci.org/nextcloud/app-tutorial)

This is the [tutorial app](https://docs.nextcloud.com/server/latest/developer_manual/app/tutorial.html) which shows how to develop a very simple notes app.
 
## Try it 
To install it change into your Nextcloud's apps directory:

    cd nextcloud/apps

Then run:

    git clone https://github.com/nextcloud/app-tutorial.git notestutorial

Then install the dependencies using:

    make composer

## Frontend development

The app tutorial also shows the very basic implementation of an app frontend using [Vue.js](https://vuejs.org/). To build the frontend code after doing changes to its source in `src/` requires to have Node and npm installed.

- 👩‍💻 Run `make dev-setup` to install the frontend dependencies
- 🏗 To build the Javascript whenever you make changes, run `make build-js`

To continuously run the build when editing source files you can make use of the `make watch-js` command.
