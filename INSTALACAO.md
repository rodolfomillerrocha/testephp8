# 🚀 Guia de Instalação Rápida - GeoApp

Este guia detalhado vai te ajudar a configurar o projeto do zero.

## ⚠️ IMPORTANTE: Leia Antes de Começar

Este projeto requer **PHP 8.4** e **Composer**. Se você não tem esses instalados, siga os passos abaixo.

## 📦 Passo 1: Instalar PHP 8.4

### Windows

1. Baixe o PHP 8.4 de: https://windows.php.net/download/
2. Escolha a versão **Thread Safe** (x64)
3. Extraia para `C:\php`
4. Adicione `C:\php` ao PATH:
   - Clique com botão direito em "Este PC" > Propriedades
   - Configurações Avançadas do Sistema
   - Variáveis de Ambiente
   - Edite "Path" e adicione `C:\php`
5. Renomeie `php.ini-development` para `php.ini`
6. Edite `php.ini` e descomente as extensões:
   - `extension=curl`
   - `extension=fileinfo`
   - `extension=gd`
   - `extension=mbstring`
   - `extension=openssl`
   - `extension=pdo_pgsql`
   - `extension=zip`

### Verificar Instalação

Abra o terminal (PowerShell) e digite:

```powershell
php -v
```

Deve mostrar a versão 8.4.x

## 📦 Passo 2: Instalar Composer

### Windows

1. Baixe o Composer-Setup.exe de: https://getcomposer.org/download/
2. Execute o instalador e siga as instruções
3. Verifique a instalação:

```powershell
composer -V
```

## 📦 Passo 3: Instalar PostgreSQL

### Opção A: Docker (Mais Fácil)

1. Baixe e instale Docker Desktop: https://www.docker.com/products/docker-desktop/
2. Inicie o Docker Desktop
3. No terminal, na pasta do projeto:

```powershell
docker-compose up -d
```

Aguarde alguns minutos para o download e inicialização.

### Opção B: PostgreSQL Local

1. Baixe PostgreSQL: https://www.postgresql.org/download/windows/
2. Durante a instalação, marque **PostGIS** nas extensões
3. Configure:
   - Porta: 5432
   - Usuário: postgres
   - Senha: (anote sua senha)
4. Após instalação, abra pgAdmin ou psql e crie o banco:

```sql
CREATE DATABASE geoapp_db;
CREATE USER geoapp_user WITH PASSWORD 'geoapp_password';
GRANT ALL PRIVILEGES ON DATABASE geoapp_db TO geoapp_user;
```

5. Conecte ao banco geoapp_db e rode:

```sql
CREATE EXTENSION IF NOT EXISTS postgis;
```

## 📦 Passo 4: Configurar o Projeto

### 1. Navegue até a pasta do projeto

```powershell
cd C:\sites\empresa-senior-mt
```

### 2. Instale as dependências

```powershell
composer install
```

**Atenção:** Isso pode demorar 5-10 minutos na primeira vez.

### 3. Configure o ambiente

```powershell
copy .env.example .env
```

### 4. Edite o arquivo .env

Abra o arquivo `.env` com um editor de texto e confirme:

```env
APP_NAME=GeoApp
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=geoapp_db
DB_USERNAME=geoapp_user
DB_PASSWORD=geoapp_password
```

**Se você instalou PostgreSQL localmente**, ajuste `DB_HOST`, `DB_USERNAME` e `DB_PASSWORD` conforme sua instalação.

### 5. Gerar chave da aplicação

```powershell
php artisan key:generate
```

### 6. Executar migrações

```powershell
php artisan migrate
```

**Se tudo estiver correto**, você verá mensagens de sucesso criando as tabelas.

### 7. Criar usuário administrador

```powershell
php artisan make:filament-user
```

Siga as instruções:
- Nome: (seu nome)
- Email: (seu email)
- Senha: (escolha uma senha forte)
- Confirme a senha

### 8. Criar link simbólico para storage

```powershell
php artisan storage:link
```

## 🎉 Passo 5: Iniciar o Servidor

```powershell
php artisan serve
```

Você verá uma mensagem:

```
INFO  Server running on [http://127.0.0.1:8000]
```

## 🌐 Acessar a Aplicação

1. **Página Inicial (Mapa)**: http://localhost:8000
2. **Painel Administrativo**: http://localhost:8000/painel
   - Faça login com o email e senha criados

## ✅ Verificar se Está Funcionando

### No Painel Admin (/painel):

1. Faça login
2. Clique em "Camadas" no menu lateral
3. Clique em "Nova Camada"
4. Preencha:
   - Nome: Teste
   - Arquivo GeoJSON: Use um dos arquivos exemplo em `storage/app/`
5. Salve

### Na Página Inicial (/):

1. Recarregue a página
2. Você deve ver o mapa com sua camada carregada

## 🐛 Problemas Comuns

### Erro: "Class not found" ou "Composer install"

Execute novamente:

```powershell
composer dump-autoload
```

### Erro: "Could not find driver" ou "pdo_pgsql"

Certifique-se de que a extensão `pdo_pgsql` está habilitada no `php.ini`:

```ini
extension=pdo_pgsql
```

Reinicie qualquer terminal/servidor em execução.

### Erro: "Connection refused" ao acessar banco

**Docker:**
```powershell
docker-compose ps
docker-compose logs db
```

**Local:** Verifique se o PostgreSQL está rodando:
- Windows: Services > PostgreSQL

### Erro: "Permission denied" no storage

```powershell
icacls storage /grant Users:F /T
```

### Mapa não carrega

1. Abra o Console do Navegador (F12)
2. Verifique erros no console
3. Teste a API: http://localhost:8000/api/camadas

## 📚 Próximos Passos

Após a instalação bem-sucedida:

1. Leia o **README.md** completo
2. Explore o código-fonte
3. Cadastre algumas camadas
4. Teste diferentes tipos de geometrias (Point, Polygon, LineString)

## 🆘 Precisa de Ajuda?

Verifique:
- [Documentação do Laravel](https://laravel.com/docs)
- [Documentação do Filament](https://filamentphp.com/docs)
- Logs de erro: `storage/logs/laravel.log`

---

**Desenvolvido com ❤️ para a Empresa Senior MT**






