# Test task for commission calculation

### Requirements to run locally
- Unix based OS. Code should work on other systems, but commands bellow are written only for UNIX based systems
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
  `./vendor/bin/phpunit tests --testdox`

### To run with Docker:
- Install composer dependencies: <br />
  `docker run --rm -it -v "$(pwd):/app" composer/composer install`
- To run main script you can use the following command: <br />
  `docker run -it --rm --name commission_calculation -v "$PWD":/usr/src/commission_calculation -w /usr/src/commission_calculation php:8.3-cli php app.php input.txt`
- To run tests you can use the following command: <br />
  `docker run -it --rm --name commission_calculation -v "$PWD":/usr/src/commission_calculation -w /usr/src/commission_calculation php:8.3-cli ./vendor/bin/phpunit tests --testdox`
<br /><br />
- Might be useful to make aliases, if you want to execute scripts multiple times with different arguments: <br />
  - `alias php-commission='docker run -it --rm --name commission_calculation -v "$PWD":/usr/src/commission_calculation -w /usr/src/commission_calculation php:8.3-cli php '` <br />
  Then you can run main command: `php-commission app.php input.txt`
  - `alias phpunit-commission='docker run -it --rm --name commission_calculation -v "$PWD":/usr/src/commission_calculation -w /usr/src/commission_calculation php:8.3-cli ./vendor/bin/phpunit '` <br />
    Then you can run tests command: `phpunit-commission tests`
- Cleanup after usage of docker approach: <br />
  - `docker rmi -f php:8.3-cli && docker rmi -f composer/composer && unalias php-commission phpunit-commission`
