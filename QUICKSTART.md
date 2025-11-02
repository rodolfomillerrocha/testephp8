# 🚀 Quick Start - GeoApp

Guia rápido para rodar o projeto em **5 minutos**.

## ⚡ Pré-requisitos Rápidos

Você precisa ter instalado:
- ✅ PHP 8.4+
- ✅ Composer  
- ✅ PostgreSQL com PostGIS OU Docker

Se não tiver, veja: **INSTALACAO.md**

## 📝 Passos Rápidos

### 1. Instalar Dependências
```bash
composer install
```

### 2. Configurar Ambiente
```bash
# Copiar arquivo de configuração
copy .env.example .env

# Gerar chave
php artisan key:generate

# Editar .env (configure seu banco de dados)
```

### 3. Configurar Banco de Dados

**Opção Docker:**
```bash
docker-compose up -d
```

**Opção Local:**
Configure PostgreSQL com PostGIS (veja INSTALACAO.md)

### 4. Migrar Banco
```bash
php artisan migrate
```

### 5. Criar Admin
```bash
php artisan make:filament-user
```

### 6. Iniciar
```bash
php artisan serve
```

## 🌐 Acessos

- **Mapa**: http://localhost:8000
- **Admin**: http://localhost:8000/painel

## ✅ Teste Rápido

1. Login no painel
2. Criar uma camada
3. Upload de GeoJSON
4. Ver no mapa

**Pronto! 🎉**

## 🆘 Problemas?

- Veja **INSTALACAO.md** para guia completo
- Veja **README.md** para documentação
- Verifique `storage/logs/laravel.log`

---

**Boa sorte! 🍀**






