# Customer support analytics

This PHP app reads information about customer data sorted by category and service type. If the line starts with C, it acts as record and if it starts with D, it acts as query to call all records after the last query.
The result is average waiting time of given sequence of records filtered by query.

## Architecture

The app is written in plain PHP and is meant to be implemented further with a command reading provided input. The functionality demonstration is done by in provided tests. The main logic is handled in App\Service\MainService

## Installation

1. `composer install`

## Usage

1. run unit tests `php vendor/bin/phpunit tests/`
