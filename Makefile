# This file is licensed under the Affero General Public License version 3 or
# later. See the COPYING file.
# @author Bernhard Posselt <dev@bernhard-posselt.com>
# @copyright Bernhard Posselt 2016

app_name=$(notdir $(CURDIR))
build_tools_directory=$(CURDIR)/build/tools
source_build_directory=$(CURDIR)/build/artifacts/source
source_package_name=$(source_build_directory)/$(app_name)
appstore_build_directory=$(CURDIR)/build/artifacts/appstore
appstore_package_name=$(appstore_build_directory)/$(app_name)
composer=$(shell which composer 2> /dev/null)

all: build

.PHONY: build
build:
	make composer

# Installs and updates the composer dependencies. If composer is not installed
# a copy is fetched from the web
.PHONY: composer
composer:
ifeq (, $(composer))
	@echo "No composer command available, downloading a copy from the web"
	mkdir -p $(build_tools_directory)
	curl -sS https://getcomposer.org/installer | php
	mv composer.phar $(build_tools_directory)
	php $(build_tools_directory)/composer.phar install --prefer-dist
	php $(build_tools_directory)/composer.phar update --prefer-dist
else
	composer install --prefer-dist
	composer update --prefer-dist
endif

.PHONY: clean
clean:
	rm -rf ./build

.PHONY: distclean
distclean: clean
	rm -rf vendor

# Builds the source and appstore package
.PHONY: dist
dist:
	make source
	make appstore

.PHONY: source
source:
	rm -rf $(source_build_directory) $(source_artifact_directory)
	mkdir -p $(source_build_directory) $(source_artifact_directory)
	rsync -rv . $(source_build_directory) \
	--exclude=/.git/ \
	--exclude=/.idea/ \
	--exclude=/build/ \
	--exclude=/js/node_modules/ \
	--exclude=*.log

.PHONY: appstore
appstore:
	rm -rf $(appstore_build_directory) $(appstore_artifact_directory)
	mkdir -p $(appstore_build_directory) $(appstore_artifact_directory)
	cp --parents -r \
	"appinfo" \
	"css" \
	"img" \
	"lib" \
	"templates" \
	"vendor" \
	"COPYING" \
	"CHANGELOG.md" \
	"js/script.js" \
	"js/handlebars.js" \
	$(appstore_build_directory)

.PHONY: test
test:
	./vendor/phpunit/phpunit/phpunit -c phpunit.xml
	./vendor/phpunit/phpunit/phpunit -c phpunit.integration.xml
