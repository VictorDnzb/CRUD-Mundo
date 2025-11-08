#  Lust - Sistema de Gerenciamento de Países e Cidades

##  Descrição do Projeto

O **Lust** é uma aplicação web completa desenvolvida para gerenciar dados geográficos de países e cidades ao redor do mundo. O sistema implementa operações CRUD (Create, Read, Update, Delete) com uma interface intuitiva e responsiva, permitindo o cadastro, consulta, edição e exclusão de informações geográficas.

##  Objetivo

Criar uma plataforma que facilite o gerenciamento de dados geográficos, integrando front-end moderno com back-end robusto e banco de dados relacional, enriquecido com informações de APIs externas.

##  Tecnologias Utilizadas

### Front-End
- **HTML5** - Estrutura semântica da aplicação
- **CSS3** - Estilização e design responsivo
- **JavaScript** - Interatividade e validações

### Back-End
- **PHP** - Lógica de negócio e comunicação com o banco
- **MySQL** - Armazenamento e gerenciamento de dados

##  Estrutura do Projeto

```
CrudMundo/
│
├── css/
│   └── style.css              # Estilos principais da aplicação
│
├── js/
│   └── app.js                 # JavaScript para interações e validações
│
├── php/
│   ├── db.php                 # Conexão com o banco de dados
│   ├── paises.php             # Operações CRUD para países
│   └── cidades.php            # Operações CRUD para cidades
│
├── bd_mundo.sql               # Script de criação do banco de dados
├── index.html                 # Página principal da aplicação
└── README.md                  # Documentação do projeto
```

## Estrutura do Banco de Dados

### Tabela: países
- `id_pais` (PK) - Identificador único do país
- `nome` - Nome oficial do país
- `continente` - Continente onde está localizado
- `populacao` - População total do país
- `idioma` - Idioma principal

### Tabela: cidades
- `id_cidade` (PK) - Identificador único da cidade
- `nome` - Nome da cidade
- `populacao` - População da cidade
- `id_pais` (FK) - Referência ao país

##  Funcionalidades

###  Gerenciamento de Países
- Cadastro de novos países
- Listagem completa de países
- Edição de informações existentes
- Exclusão com verificação de integridade referencial

###  Gerenciamento de Cidades
- Cadastro de cidades associadas a países
- Listagem de cidades por país
- Edição de dados das cidades
- Exclusão controlada

##  Como abrir o projeto

### Pré-requisitos
- Servidor web (Apache, Nginx)
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Navegador web moderno

### Instalação

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/VictorDnzb/CRUD-Mundo.git
   ```

2. **Configure o banco de dados:**
   - Execute o script `bd_mundo.sql` no MySQL
   - Configure as credenciais no arquivo `php/db.php`

3. **Acesse a aplicação:**
   - Abra o navegador e acesse `http://localhost/Crud-Mundo`

###  Estatísticas

- Total de cidades cadastradas por continente


##  Desenvolvedor

**Victor Diniz**  
*Estudante de Desenvolvimento de sistemas*  
[vcr.dnz@gmail.com] | [https://www.linkedin.com/in/victor-diniz-bento-674026314/]

---
