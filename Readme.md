# Test task for commission calculation

### Prerequisites:
- Unix based OS
- Docker or (PHP 8.3 and Composer) are installed locally

### General steps:
- Copy file .env.example into .env file
  `cp .env.example .env`
- Fill .env file with https://exchangeratesapi.io/ API key
  - or set `APP_ENV=test` to use mocked API's

### To run locally:
- Install composer dependencies:
  `composer install`
- Run the main script:
  `php app.php input.txt`
- Run tests:
  `./vendor/bin/phpunit tests`

### To run with Docker:
- Install composer dependencies: <br />
  `docker run --rm -it -v "$(pwd):/app" composer/composer install`
- To run main script you can use the following command: <br />
  `docker run -it --rm --name commission_calculation -v "$PWD":/usr/src/commission_calculation -w /usr/src/commission_calculation php:8.3-cli php app.php input.txt`
- To run tests you can use the following command: <br />
  `docker run -it --rm --name commission_calculation -v "$PWD":/usr/src/commission_calculation -w /usr/src/commission_calculation php:8.3-cli ./vendor/bin/phpunit tests --testdox`
- Might be useful to make aliases: <br />
  - `alias php-commission='docker run -it --rm --name commission_calculation -v "$PWD":/usr/src/commission_calculation -w /usr/src/commission_calculation php:8.3-cli php '` <br />
  Then you can run commands like: `php-commission app.php input.txt` <br /> <br />
  - `alias phpunit-commission='docker run -it --rm --name commission_calculation -v "$PWD":/usr/src/commission_calculation -w /usr/src/commission_calculation php:8.3-
    cli ./vendor/bin/phpunit '` <br />
    Then you can run commands like: `phpunit-commission tests`
