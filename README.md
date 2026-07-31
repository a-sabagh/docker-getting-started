# Docker Getting Started

Hands-on Docker examples covering Dockerfiles, images, build arguments, `COPY`,
entrypoints, networking, and Docker Compose.

This repository is the practical companion to the
[Docker Getting Started YouTube playlist](https://www.youtube.com/playlist?list=PLPIQWyi2FB6JeXGm9lh876925SNQjWyCf).
Watch the lessons for the explanations, then use the examples here to practice
the commands and experiment with each concept.

> [!NOTE]
> This is a learning repository. The examples are intentionally small and focus
> on one Docker concept at a time; they are not production-ready application
> templates.

## What you will practice

- Building images from Dockerfiles
- Choosing base images and installing packages
- Understanding build context and image layers
- Copying files into an image and setting permissions with `COPY --chmod`
- Using `WORKDIR`, `USER`, `CMD`, `ENTRYPOINT`, `ARG`, `LABEL`, and `EXPOSE`
- Passing build arguments to create configurable images
- Running interactive and networked containers
- Extending official PHP images
- Starting multiple services with Docker Compose
- Using common troubleshooting tools inside a container

## Prerequisites

Install one of the following:

- [Docker Desktop](https://docs.docker.com/desktop/) on Windows, macOS, or Linux
- [Docker Engine](https://docs.docker.com/engine/install/) with the Docker
  Compose plugin on Linux

Confirm that Docker and Compose are available:

```bash
docker --version
docker compose version
```

Clone the repository and enter it:

```bash
git clone https://github.com/a-sabagh/docker-getting-started.git
cd docker-getting-started
```

## Repository examples

| Directory | Main concept | What it demonstrates |
| --- | --- | --- |
| `php-itwork/` | First image | Copying and running a small PHP application |
| `docker-entrypoint-phpserver/` | `ENTRYPOINT` and `CMD` | Serving a page with PHP's built-in web server |
| `dockerfile-arg-instruction/` | Build arguments | Configuring environment and Ubuntu version at build time |
| `dockerfile-entrypoint-phonebook/` | Entrypoint script | Container initialization followed by the main process |
| `dockerfile-ubuntu-copy/` | `COPY`, permissions, and users | File copying, executable permissions, `WORKDIR`, and `USER` |
| `php-zip-image/` | Extending an image | Adding the ZIP extension to the official PHP Apache image |
| `phpmyadmin/` | Docker Compose | Running MySQL and phpMyAdmin together |
| `docker-images/` | Reusable images | Building a Debian image with `procps` and consuming it with Compose |
| `ubuntu-netutils/` | Utility image | Installing common network diagnostic commands |

## Running the examples

All commands below are intended to be run from the repository root.

### 1. Basic PHP image

Build an image containing two PHP scripts and a shell startup script:

```bash
docker build -t php-itworks ./php-itwork
docker run --rm php-itworks
```

The container runs `run.sh`, which executes both PHP files and prints their
output.

### 2. PHP web server with `ENTRYPOINT` and `CMD`

```bash
docker build -t php-entrypoint-server ./docker-entrypoint-phpserver
docker run --rm -p 8080:80 php-entrypoint-server
```

Open <http://localhost:8080> in a browser. The Dockerfile combines:

```dockerfile
ENTRYPOINT ["php"]
CMD ["-S", "0.0.0.0:80"]
```

Docker appends the default `CMD` arguments to the `ENTRYPOINT`, producing
`php -S 0.0.0.0:80` when the container starts. Stop it with `Ctrl+C`.

### 3. Dockerfile build arguments

Build with the default `APP_ENV=development` value:

```bash
docker build -t arg-example ./dockerfile-arg-instruction
```

Override it during the build:

```bash
docker build \
  --build-arg APP_ENV=production \
  -t arg-example:production \
  ./dockerfile-arg-instruction
```

`DesiredUbuntuDockerfile` also demonstrates using an argument before `FROM` to
select the Ubuntu base-image version:

```bash
docker build \
  -f dockerfile-arg-instruction/DesiredUbuntuDockerfile \
  --build-arg VERSION=24.04 \
  -t desired-ubuntu:24.04 \
  ./dockerfile-arg-instruction
```

Build arguments affect image creation. Do not use them for passwords, tokens,
or other secrets because build data can be exposed through image metadata and
build history.

### 4. Phonebook entrypoint

```bash
docker build -t phonebook ./dockerfile-entrypoint-phonebook
docker run --rm -it phonebook
```

Enter phone numbers at the prompt, or type `exit` to stop. The entrypoint script
creates `/root/data.txt` and then uses `exec "$@"` to replace itself with the
Dockerfile's default `phonebook` command. This is the standard pattern for doing
initialization work while still forwarding signals to the main container
process.

### 5. `COPY`, permissions, `WORKDIR`, and `USER`

```bash
docker build -t ubuntu-copy ./dockerfile-ubuntu-copy
docker run --rm -it ubuntu-copy
```

Type a name and the PHP program responds; type `exit` to stop. Inspect the
Dockerfile and `.dockerignore` to see which files enter the build context, how
`COPY --chmod` makes scripts executable, and how `USER ubuntu` runs the final
command as a non-root user.

The directory also contains diagrams and small placeholder files used while
experimenting with build context, file paths, and image layers.

### 6. PHP image with ZIP support

Build an Apache-based PHP image with the ZIP extension installed:

```bash
docker build -t php-with-zip ./php-zip-image
docker run --rm php-with-zip php -m
```

Look for `zip` in the printed module list. To start Apache instead, publish its
HTTP port:

```bash
docker run --rm -p 8080:80 php-with-zip
```

### 7. MySQL and phpMyAdmin with Compose

Start both services in the background:

```bash
docker compose -f phpmyadmin/compose.yml up -d
docker compose -f phpmyadmin/compose.yml ps
```

Open <http://localhost:8082> and connect with:

| Setting | Value |
| --- | --- |
| Server | `3309db` |
| Username | `root` |
| Password | `root` |

MySQL is also published on host port `3309`. View service logs or stop and
remove the containers with:

```bash
docker compose -f phpmyadmin/compose.yml logs -f
docker compose -f phpmyadmin/compose.yml down
```

> [!WARNING]
> The hard-coded root password and published database port are for local
> practice only. Use secrets, restricted network access, persistent storage,
> and non-root database users in a real deployment.

### 8. Reusable Debian `procps` image

Build the image with the same tag referenced by the Compose file:

```bash
docker build \
  -f docker-images/debian_procps-trixie-dockerfile \
  -t sabagh/debian_procps:trixie \
  ./docker-images
```

Run it through Compose and try a process command supplied by `procps`:

```bash
docker compose -f docker-images/procps-compose/compose.yaml up -d
docker exec -it debian_procps-latest ps aux
docker compose -f docker-images/procps-compose/compose.yaml down
```

The Compose example can also use the published
`sabagh/debian_procps:trixie` image when it is not available locally.

### 9. Ubuntu network utilities

```bash
docker build -t ubuntu-netutils ./ubuntu-netutils
docker run --rm -it ubuntu-netutils
```

The image includes `ping`, `ip`, `traceroute`, `nc`, `dig`, `curl`, and `wget`.
For example:

```bash
ip addr
dig example.com
curl -I https://example.com
```

Network behavior depends on the container runtime, host configuration, DNS,
and whether the environment allows outbound access.

## Useful Docker commands

```bash
# Show running containers
docker ps

# Show all containers
docker ps -a

# List local images
docker image ls

# Follow a container's logs
docker logs -f <container-name-or-id>

# Open a shell in a running container
docker exec -it <container-name-or-id> sh

# Stop a container
docker stop <container-name-or-id>

# Inspect an image's build history
docker image history <image-name>
```

## Suggested learning workflow

1. Watch the matching lesson in the
   [YouTube playlist](https://www.youtube.com/playlist?list=PLPIQWyi2FB6JeXGm9lh876925SNQjWyCf).
2. Read the relevant Dockerfile or Compose file before building it.
3. Build and run the example using the commands above.
4. Change one instruction or option and predict the result.
5. Rebuild, observe Docker's layer cache, and compare the behavior.
6. Stop and remove resources when you finish the exercise.

## Troubleshooting

### A port is already in use

Change the host side (the number before `:`) of a port mapping. For example:

```bash
docker run --rm -p 8081:80 php-entrypoint-server
```

### A container exits immediately

Check its output and inspect stopped containers:

```bash
docker ps -a
docker logs <container-name-or-id>
```

Containers stop when their main process exits. Use `-it` for examples that read
interactive input.

### A build uses stale files

Rebuild without the layer cache:

```bash
docker build --no-cache -t <image-name> <build-context>
```

### Compose resources are still running

Run `down` with the same file used for `up`:

```bash
docker compose -f <path-to-compose-file> down
```

## Contributing

Issues and pull requests that improve the examples or documentation are
welcome. Keep additions focused, easy to run, and aligned with the educational
playlist.
