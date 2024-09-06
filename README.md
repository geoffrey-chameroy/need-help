# Symfony and NextJS Project with Docker

## Prerequisites

Before you begin, ensure you have the following installed on your machine:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Installation

1. **Create your environment**:

   Copy docker-compose.override.yml.dist:

   `cp docker-compose.override.yml.dist docker-compose.override.yml`

   Feel free to change the ports.

2. **Start Docker Compose**:

   Ensure Docker and Docker Compose are running, then execute:

   `docker-compose up -d`

   This command starts the containers in the background.

3. **Apply database migrations**:

   Run the following command to download dependencies:

   `docker-compose exec php composer install`

4. **Apply database migrations**:

   Run the following command to apply database migrations:

   `docker-compose exec php php bin/console d:m:m -n`

5. **Load fixtures**:

   To load fixtures, use the command:

   `docker-compose exec php php bin/console d:f:l -n`

## Access

- **Web Application**: [http://localhost:3000](http://localhost:3000)
- **API**: [http://localhost:8000](http://localhost:8000)
- **phpMyAdmin**: [http://localhost:8002](http://localhost:8002)

## Stopping Containers

To stop the containers, run:

`docker-compose down`

The database will not be erased

## Tests and PSR

To run api tests suite:

`docker-compose exec php php vendor/bin/codecept run`

To fix psr norms, run:

`docker-compose exec php vendor/bin/php-cs-fixer fix`
