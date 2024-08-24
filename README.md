
# WordPress Development Environment

This repository sets up a WordPress development environment using Docker.

## Commands

Here are the available make commands to manage the development environment:

- `make install`: Stops any running containers, builds the containers, and starts the environment.
- `make start`: Starts the Docker containers.
- `make stop`: Stops the Docker containers.
- `make enter_php`: Opens a shell in the PHP container.
- `make enter_phpmyadmin`: Opens a shell in the phpMyAdmin container.
- `make enter_node`: Opens a shell in the Node.js container.
- `make build_container`: Builds the Docker containers.
- `make clean_install`: Stops any running containers, cleans up the network, rebuilds the containers, and starts the environment.
- `make dev`: Runs the development script using Yarn inside the Node.js container.
- `make build`: Runs the build script using Yarn inside the Node.js container.
- `make export_db`: Exports the database using a custom script.
- `make import_db`: Imports the database using a custom script.

## Usage

Run these commands using `make <command>` to control the Docker environment for your WordPress development.
