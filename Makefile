.PHONY: help

PLATFORM :=

ifeq ($(OS),Windows_NT)
	PLATFORM := windows
else
	UNAME_S := $(shell uname -s)
ifeq ($(UNAME_S),Linux)
	PLATFORM := linux
else
ifeq ($(UNAME_S),Darwin)
	PLATFORM := osx
endif
endif
endif

help:
	$(info > `make install` to install the dependencies for production)
	$(info - `make test` to run automated tests)
	$(info Detected platform: $(PLATFORM).)
	$(info )
	@ls > /dev/null

install: composer-install
install: npm-install

composer-install:
	$(info Installing Composer dependencies)
	cd backend; composer install; cd ../
npm-install:
	$(info Installing NPM dependencies)
	cd frontend; npm install; cd ../

.PHONY: test phpunit

test:: composer-install
test:: phpunit

docker:
	docker-compose up -d

down:
	docker-compose down

docker-build:
	docker-compose up -d --build
print-access-info:
	$(info Access the frontend on "http://localhost:8080")

up:: install
up:: docker-build
up:: print-access-info

phpunit::
	$(info Running PhpUnit)
	cd backend; php artisan test; cd ../
