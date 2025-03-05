#!/bin/bash

echo "Hello! Welcome to the Pokemon Docker startup script."

echo "--------------------------------------------------"
echo "Now, rebuilding the containers..."
echo "--------------------------------------------------"

sudo docker-compose up --build

echo "--------------------------------------------------"
echo "Docker containers are up and running again. Have a great day!"
