#!/bin/bash

echo "Iniciando instalação do projeto Loop..."

# ===========================
# COPIAR ENV DO BACKEND
# ===========================
if [ ! -f backend/.env ]; then
  echo "Criando backend/.env..."
  cp backend/.env.example backend/.env
else
  echo "backend/.env já existe, pulando..."
fi

# ===========================
# COPIAR ENV DO FRONTEND
# ===========================
if [ -f frontend/.env.example ] && [ ! -f frontend/.env ]; then
  echo "Criando frontend/.env..."
  cp frontend/.env.example frontend/.env
else
  echo "frontend/.env já existe ou não possui .env.example"
fi

# ===========================
# SUBIR CONTAINERS
# ===========================
echo "Subindo containers..."
docker compose up -d

echo "Aguardando containers iniciarem..."
sleep 5

# ===========================
# MIGRATIONS
# ===========================
echo "Executando migrations..."
cd backend
composer migrate

echo "Backend pronto!"

# ===========================
# FRONTEND INSTALL
# ===========================

echo "Frontend pronto!"

echo ""
echo "Ambiente iniciado com sucesso!"
echo "API:      http://localhost:8080"
echo "Frontend: http://localhost:5174"
echo ""
