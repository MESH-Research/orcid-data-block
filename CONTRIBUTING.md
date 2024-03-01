## Development Prerequisites

* git
* npm
* Docker or Docker Desktop

## Installation for Development

1. Clone this repository from GitHub onto your computer
2. Open a command-line and navigate to the directory of the cloned repository
3. Ensure npm has all installed dependencies and run:
    * `npm i`
4. Run the project's build script:
    * `npm run build`
5. Run this command to copy the environment variables file:
    * `cp .env.sample .env`
6. Run this command to copy the Docker configuration file:
    * `cp docker-compose.yml.sample docker-compose.yml`
    * Optionally, uncomment the code in `docker-compose.yml` to enable a persistent database
7. If using Docker Desktop, open it
8. Run this command `docker-compose up --detach`

## WordPress Debugging

Edit `wp-config.php` to include

```php
//define( 'WP_DEBUG', !!getenv_docker('WORDPRESS_DEBUG', '') );
define( 'WP_DEBUG', true);
//
define( 'WP_DEBUG_LOG', true );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );
define( 'WP_DEBUG_DISPLAY', true );
```

# Docker Development Instructions for WP ORCiD Plugin

## Steps

* Copy the sample .env file (edit as needed).

  ```sh
  cp .env.sample .env
  ```

* Copy the sample docker-compose.yml file (edit as needed).

  ```sh
  cp .docker-compose.yml.sample .docker-compose.yml
  ```

* Launch the wordpress containers.

  ```sh
  docker compose up -d
  ```

* Log into the WP instance (`localhost:8000`) and complete the installation.
* Go to the Admin page and activate the plugin.
* To shut down the docker instance run:

  ```sh
  docker compose down
  ```
