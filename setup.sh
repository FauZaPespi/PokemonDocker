#!/bin/bash

echo "Hello! Welcome to the Pokemon Docker setup script."
echo "We are about to shut down the Docker containers and rebuild them."

echo "Stopping and removing existing containers..."
sudo docker-compose down

echo "--------------------------------------------------"
echo "All containers have been stopped and removed!"
echo "Now, rebuilding the containers..."
echo "--------------------------------------------------"

sudo docker-compose up --build

echo "--------------------------------------------------"
echo "Docker containers are up and running again. Have a great day!"
