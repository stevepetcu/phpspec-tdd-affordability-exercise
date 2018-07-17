OS := $(shell uname)
DOCKER_MACHINE := phpspec-tdd-affordability-exercise
DOCKER_MACHINE_STATE := $(shell docker-machine ls --filter name=$(DOCKER_MACHINE) --format "{{.State}}")
EVALUATED_DOCKER_MACHINE := ${DOCKER_MACHINE_NAME}

.DEFAULT_GOAL := all
.PHONY: all build up install update test run check-env

all: build install test run

build: check-env
	docker-compose up -d --build

up: check-env
	docker-compose up -d

install: check-env
	docker-compose exec php composer install

update: check-env
	docker-compose exec php composer update

test: check-env
	docker-compose exec php ./vendor/bin/phpspec run --verbose

run: check-env
	docker-compose exec php ./bin/console


check-env:
ifneq ($(OS),Linux)
ifeq ($(DOCKER_MACHINE_STATE),)
	$(warning Docker machine "$(DOCKER_MACHINE)" not found.)
	$(warning Please run the following command to create and evaluate the machine:)
	$(warning docker-machine create $(DOCKER_MACHINE) && eval $$(docker-machine env $(DOCKER_MACHINE)))
	$(error Docker machine "$(DOCKER_MACHINE)" not found)
endif
ifneq ($(DOCKER_MACHINE_STATE),Running)
	$(warning Docker machine "$(DOCKER_MACHINE)" found in unexpected state: "$(DOCKER_MACHINE_STATE)" (expected: "Running").)
	$(warning Please run the following command to start and evaluate the machine:)
	$(warning docker-machine start $(DOCKER_MACHINE) && eval $$(docker-machine env $(DOCKER_MACHINE)))
	$(error Docker machine "$(DOCKER_MACHINE)" not running)
endif
ifneq ($(EVALUATED_DOCKER_MACHINE),$(DOCKER_MACHINE))
	$(warning Docker machine "$(DOCKER_MACHINE)" is not evaluated in the current terminal. Please run the following command:)
	$(warning eval $$(docker-machine env $(DOCKER_MACHINE)))
	$(error Docker machine "$(DOCKER_MACHINE)" not evaluated in current terminal)
endif
endif
