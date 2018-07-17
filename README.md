# Affordability Service Exercise

Service that allows tenants to carry out an affordability check against a list of properties.

## Setting up the environment for first run

### Prerequisites

#### Linux

- docker
- docker-compose

#### MacOS

- docker
- docker-compose
- VirtualBox

##### Setup the docker machine:
```bash
docker-machine create phpspec-tdd-affordability-exercise && eval $(docker-machine env phpspec-tdd-affordability-exercise)
```

## Do all the things

Install dependencies, run tests and run the application:
```bash
make all
```

**Note**: you might be required to regenerate the docker machine's certificates (select `y`):
```bash
docker-machine regenerate-certs phpspec-tdd-affordability-exercise
```

## Upping the docker containers

Start the docker containers, but skip everything else:
```bash
make up
```

## Installing dependencies

Install composer dependencies, but skip everything else:
```bash
make install
```

## Running the tests

Run the tests, but skip everything else:
```bash
make test
```

## Running the application

Run the application, but skip everything else:
```bash
make run
```

## Assumptions

- The goal of this service is to allow "tenants to carry out an affordability check against a list of properties".
Thus, the assumption is that the data distribution of the information that the service has to deal with will be 
greatly skewed towards a larger number of properties and relatively little data on the part of the tenant.
This is reflected in how these data streams are handled by the application.
- If a tenant's income or expense occurs more than once in the time period that we process, it is considered a recurring
transaction and it counts towards the tenant's affordability score
- The specification pattern could be extended with a strategy counterpart, having a specification provider alongside a 
strategy provider injected in the `AffordabilityService` - but YAGNI for this

## Improvements wanted
- Don't use `root` as user in the php-fpm container.
