#!/bin/bash

echo "Iniciando instalação do projeto Loop..."

# ===========================
# COPIAR ENV DO BACKEND
# ===========================
if [ ! -f backend/.env ]; then
  echo "Criando backend/.env..."
  cp -f backend/.env.example backend/.env
else
  echo "backend/.env já existe, pulando..."
fi

if [ -f frontend/.env.example ] && [ ! -f frontend/.env ]; then
  echo "Criando frontend/.env..."
  cp -f frontend/.env.example frontend/.env
else
  echo "frontend/.env já existe ou não possui .env.example"
fi

echo "Subindo containers..."

docker compose down

docker compose up -d

echo "Aguardando containers iniciarem..."
sleep 5

docker exec -it api composer install

echo "Executando migrations..."
cd backend
composer migrate

echo "Backend pronto!"

echo "Frontend pronto!"

echo ""
echo "Ambiente iniciado com sucesso!"
echo "API:      http://localhost:8080"
echo "Frontend: http://localhost:5174"
echo ""
