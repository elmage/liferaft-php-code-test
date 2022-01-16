#!/bin/bash

echo "Create Network If Not Already Created"
docker network inspect liferaft_services >/dev/null 2>&1 || docker network create --driver bridge liferaft_services

echo "Start Containers"
docker-compose up --build --remove-orphans
