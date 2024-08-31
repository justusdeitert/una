
# WordPress Development Environment

This repository sets up a WordPress development environment using Docker. To Install the docker environment simply running the following command:

## Install

This will stop any running containers, builds the containers new, and starts the environment.

```
make install
```

## Start Development

Runs the development script using Yarn inside the Node.js container.

```
make dev
```

## Build for Production

Runs the build script using Yarn inside the Node.js container.

```
make build
```


## Usage

Run `make help` to see all available commands.
