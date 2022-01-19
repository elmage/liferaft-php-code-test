## Getting started

Clone the repo
```
git clone https://github.com/elmage/liferaft-php-code-test.git
```

Create a `docker-compose.yml` file from the `docker-compose.sample.yml`
```
cd liferaft-php-code-test

cp docker-compose.sample.yml docker-compose.yml
```

Modify the `docker-compose.yml` as needed and Run the docker container using the command below
```
make up
```
OR
```
./docker-start.sh
```

View the app on http://127.0.0.1:8080
