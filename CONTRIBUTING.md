# Docker Development Instructions for WP ORCiD Plugin

## Steps

- Copy the sample .env file (edit as needed).

  ```sh
  cp .env.sample .env
  ```

- Run docker for the first time. This will fill the `wp` dirctory with the WP source code.

  ```sh
  docker compose up -d
  ```

- Log into the WP instance (`localhost:8000`) and complete the installation.
- Go to the Admin page and activate the plugin.
- To shut down the docker instance run:

  ```sh
  docker compose down
  ```
