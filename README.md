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

This command should guide you through the steps to setup the application.

**Note**: you might be required to regenerate the docker machine's certificates (select `y`):
```bash
docker-machine regenerate-certs phpspec-tdd-affordability-exercise
```

After setting up the docker machine successfully, repeat the `make all` command.

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

Run the application's console:
```bash
make run
```

Run the affordability check:
```bash
make affordability-check <bank_statement_filepath> <property_list_filepath>
```
e.g.,:
```bash
make affordability-check features/test_files/bank_statement.csv features/test_files/properties.csv
```

## Assumptions

- The goal of this service is to allow "tenants to carry out an affordability check against a list of properties".
Thus, the assumption is that the data distribution of the information that the service has to deal with will be 
greatly skewed towards a larger number of properties and relatively little data on the part of the tenant.
This is reflected in how these data streams are handled by the application.
- We consider "Direct Debit" transactions as recurring money out and "Direct Credit" transactions as recurring
money in.
- The specification pattern could be extended with a strategy counterpart, having a specification provider alongside a 
strategy provider injected in the `AffordabilityService` - but YAGNI for 
- We assume that the files containing the bank statement and property information are **readable**.
- The application was developed on MacOS and I didn't have the opportunity to test it on Linux. Fingers crossed 
setting it up goes reasonably smoothly.

## Improvements wanted

- Don't use `root` as user in the php-fpm container.
- Logs shouldn't be kept in the application's source code folder (or same drive for that matter).
- For scalability, results should be written in a cache/something like that as they are computed, instead of 
kept in-memory (which defeats the purpose of using Generators to read the CSV files).
- The bank statement builder should be improved (generalised) and refactored. It's probably the worst piece of code. Ever.
- Given the tight schedule (2 working days) to deliver this, it soon became apparent that I wouldn't have time to TDD 
everything (or much at all). This is far from ideal, but I decided to go at least with the high level Behat tests, to 
cover the happy path and some of the more obvious unhappy paths, to at least have some trust in the app. Unit tests are 
needed in order to avoid the reverse ice-cone issue - it shouldn't be an issue to add them after the fact, as most of the classes have been designed with that in mind (to be decoupled).
