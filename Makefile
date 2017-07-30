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
	rm -rf $(source_build_directory)
	mkdir -p $(source_build_directory)
	tar cvzf $(source_package_name).tar.gz ../$(app_name) \
	--exclude-vcs \
	--exclude="../$(app_name)/build" \
	--exclude="../$(app_name)/*.log"

.PHONY: appstore
appstore:
	rm -rf $(appstore_build_directory)
	mkdir -p $(appstore_build_directory)
	tar cvzf $(appstore_package_name).tar.gz ../$(app_name) \
	--exclude-vcs \
	--exclude="../$(app_name)/build" \
	--exclude="../$(app_name)/tests" \
	--exclude="../$(app_name)/Makefile" \
	--exclude="../$(app_name)/*.log" \
	--exclude="../$(app_name)/phpunit*xml" \
	--exclude="../$(app_name)/composer.*"

.PHONY: test
test:
	./vendor/phpunit/phpunit/phpunit -c phpunit.xml
	./vendor/phpunit/phpunit/phpunit -c phpunit.integration.xml