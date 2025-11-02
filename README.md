# GeoApp - Sistema de Gestão de Dados Geoespaciais

Sistema web desenvolvido para gerenciamento e visualização de dados georreferenciados, utilizando Laravel, Filament e ArcGIS Maps SDK.

## 📋 Descrição

O GeoApp é uma aplicação completa para administração e visualização de camadas geográficas em mapas interativos. O sistema permite o upload de arquivos GeoJSON através de um painel administrativo seguro e exibe as geometrias em um mapa web moderno.

## 🛠️ Tecnologias Utilizadas

- **Backend**: Laravel 11.x
- **Admin Panel**: Filament 3.2
- **Banco de Dados**: PostgreSQL com extensão PostGIS
- **Mapa**: ArcGIS Maps SDK for JavaScript 4.35
- **PHP**: 8.4+
- **Containerização**: Docker & Docker Compose

## 📦 Requisitos

Antes de começar, certifique-se de ter instalado:

- PHP 8.4 ou superior
- Composer
- PostgreSQL 17+ com PostGIS 3.5
- Docker e Docker Compose (opcional)
- Git

## 🚀 Instalação

### Passo 1: Clonar o Repositório

```bash
git clone <url-do-repositorio>
cd empresa-senior-mt
```

### Passo 2: Instalar Dependências

```bash
composer install
```

### Passo 3: Configurar Variáveis de Ambiente

Copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

Edite o arquivo `.env` e configure as informações do banco de dados:

```env
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=geoapp_db
DB_USERNAME=geoapp_user
DB_PASSWORD=geoapp_password
```

### Passo 4: Configurar Aplicação

```bash
php artisan key:generate
```

### Passo 5: Configurar Banco de Dados

#### Opção A: Usando Docker (Recomendado)

Inicie os containers Docker:

```bash
docker-compose up -d
```

Aguarde alguns segundos para o PostgreSQL inicializar completamente.

#### Opção B: PostgreSQL Local

Se você já possui PostgreSQL instalado localmente:

1. Crie o banco de dados:
```sql
CREATE DATABASE geoapp_db;
CREATE EXTENSION IF NOT EXISTS postgis;
```

2. Configure um usuário:
```sql
CREATE USER geoapp_user WITH PASSWORD 'geoapp_password';
GRANT ALL PRIVILEGES ON DATABASE geoapp_db TO geoapp_user;
```

### Passo 6: Executar Migrações

```bash
php artisan migrate
```

### Passo 7: Criar Usuário Administrador

Para acessar o painel administrativo, você precisa criar um usuário:

```bash
php artisan make:filament-user
```

Siga as instruções no terminal para criar seu usuário admin.

### Passo 8: Iniciar Servidor

```bash
php artisan serve
```

A aplicação estará disponível em: **http://localhost:8000**

## 🎯 Como Usar

### Acessar o Painel Administrativo

1. Acesse: `http://localhost:8000/painel`
2. Faça login com as credenciais criadas
3. No menu lateral, clique em "Camadas"

### Cadastrar uma Nova Camada

1. No painel administrativo, clique em "Nova Camada"
2. Preencha o nome da camada (máximo 100 caracteres)
3. Faça upload de um arquivo GeoJSON válido
4. Clique em "Salvar"

Exemplo de GeoJSON válido:

```json
{
  "type": "Feature",
  "geometry": {
    "type": "Point",
    "coordinates": [-47.88, -15.79]
  },
  "properties": {
    "name": "Brasília"
  }
}
```

### Visualizar no Mapa

1. Acesse a página inicial: `http://localhost:8000`
2. O mapa carregará automaticamente todas as camadas cadastradas
3. Clique em um elemento no mapa para ver os detalhes

## 📁 Estrutura do Projeto

```
empresa-senior-mt/
├── app/
│   ├── Filament/
│   │   └── Resources/
│   │       └── LayerResource/      # Recursos do Filament
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   └── CamadasController.php  # API de camadas
│   │   │   └── MapaController.php         # Controller do mapa
│   │   └── Middleware/
│   ├── Models/
│   │   └── Layer.php               # Model de Camadas
│   └── Providers/
├── config/                          # Arquivos de configuração
├── database/
│   └── migrations/
│       └── *_create_layers_table.php  # Migration da tabela layers
├── public/                         # Arquivos públicos
├── resources/
│   └── views/
│       └── mapa.blade.php         # View do mapa
├── routes/
│   ├── api.php                    # Rotas da API
│   └── web.php                    # Rotas web
├── storage/
│   └── app/
│       └── geojson/               # Arquivos GeoJSON uploadados
├── composer.json
├── docker-compose.yml
└── README.md
```

## 🔒 Segurança

- O painel administrativo é protegido por autenticação
- Arquivos GeoJSON são armazenados em diretório privado
- CSRF protection ativo em formulários
- Senhas são hasheadas com bcrypt

## 🧪 API Endpoints

A API REST está disponível nas seguintes rotas:

### GET /api/camadas
Retorna todas as camadas em formato FeatureCollection GeoJSON

**Resposta:**
```json
{
  "type": "FeatureCollection",
  "features": [
    {
      "type": "Feature",
      "properties": {
        "id": 1,
        "nome": "Minha Camada"
      },
      "geometry": {...}
    }
  ]
}
```

### GET /api/camadas/{id}
Retorna uma camada específica

## 🐛 Troubleshooting

### Erro: "PostGIS extension not found"

Certifique-se de que a extensão PostGIS está instalada:

```sql
CREATE EXTENSION IF NOT EXISTS postgis;
```

### Erro ao fazer upload de GeoJSON

Verifique se o arquivo está no formato correto. Use um validador GeoJSON online.

### Mapa não carrega

Abra o console do navegador (F12) para ver erros. Verifique se a API está respondendo corretamente em `/api/camadas`.

## 📝 Notas de Desenvolvimento

### Convenções de Código

- Nomes de variáveis e funções em português
- Comentários explicativos
- Estrutura seguindo princípios SOLID
- Isolamento de responsabilidades

### Melhorias Futuras

- Validação mais robusta de geometrias
- Suporte a múltiplos formatos (KML, Shapefile)
- Sistema de permissões granular
- Cache de queries espaciais
- Exportação de camadas

## 👨‍💻 Desenvolvimento

Este projeto foi desenvolvido como teste técnico, aplicando:

- Boas práticas de arquitetura
- Princípios SOLID
- Clean Code
- Padrões de Design apropriados
- Segurança da informação

## 📄 Licença

Este projeto é proprietário e desenvolvido exclusivamente para fins de avaliação técnica.

## 🤝 Suporte

Para dúvidas ou problemas, consulte a documentação do Laravel e Filament:

- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [ArcGIS Maps SDK](https://developers.arcgis.com/javascript/latest/)

---

**Desenvolvido com ❤️ para a Empresa Senior MT**






