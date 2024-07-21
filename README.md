# CRM Application

## Installation and Running

- Running on a development environment:

Building images:
```bash
cd docker
docker-compose -f docker-compose.yaml build
```

Starting docker containers:

```bash
cd docker
docker-compose -f docker-compose.yaml up
```

Execute startup for the application:
```bash
docker exec -it $(docker ps --filter "ancestor=docker-php" -q) bin/run_startup.sh
```

Execute tests:
```bash
docker exec -it $(docker ps --filter "ancestor=docker-php" -q) vendor/bin/phpunit
```

Run bash in mysql container:
```bash
docker exec -it $(docker ps --filter "ancestor=mysql:8.3" -q) /bin/bash
```

Run bash in php container:
```bash
docker exec -it $(docker ps --filter "ancestor=docker-php" -q) /bin/bash
```