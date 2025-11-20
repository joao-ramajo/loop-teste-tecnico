#!/bin/bash

run_migrate() {
  echo "Executando migrations..."

  cd backend

  # if composer migrate 2>/dev/null; then
  #   echo "Migrations executadas."
  #   return 0
  # fi

  if docker exec api composer migrate 2>/dev/null; then
    echo "Migrations executadas."
    return 0
  fi

  echo "ERRO: Não foi possível executar as migrations nem no host nem dentro do container."
  exit 1
}


echo "Iniciando instalação do projeto Loop..."

rm backend/.env

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
  echo "frontend/.env já existe"
fi

echo "Subindo containers..."

docker compose down -v

docker compose up -d

until docker exec db mysqladmin ping -h "localhost" --silent; do
  echo "MySQL ainda iniciando..."
  sleep 5
done

run_migrate

echo ""
echo "Ambiente iniciado com sucesso!"
echo "API:      http://localhost:8080"
echo "Frontend: http://localhost:5174"
echo ""
