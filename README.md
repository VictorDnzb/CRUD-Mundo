# 🌍 CRUD Mundo - Sistema de Gerenmento de Países e Cidades

Este projeto é uma aplicação web completa para gerenciamento de dados geográficos, permitindo o cadastro, consulta, edição e exclusão de países e cidades. Desenvolvido como parte de uma atividade avaliativa da disciplina de **Programação Web**.

---

## 📋 Descrição do Projeto

O **CRUD Mundo** é um sistema que permite:

- Cadastrar, listar, editar e excluir **países** e **cidades**.
- Manter a integridade referencial entre as entidades.
- Consultar informações climáticas em tempo real e dados complementares de países via APIs externas.
- Interface responsiva e validações no front-end e back-end.

---

## 🛠 Tecnologias Utilizadas

### Front-End:
- **HTML5** (estrutura semântica)
- **CSS3** (estilização e responsividade)
- **JavaScript** (validações e interações)

### Back-End:
- **PHP** (lógica de negócio e integração com BD)
- **MySQL** (banco de dados)

### APIs Consumidas:
- [REST Countries](https://restcountries.com/) – Dados complementares de países
- [OpenWeatherMap](https://openweathermap.org/) – Informações climáticas de cidades

### Controle de Versão:
- **Git** e **GitHub**

---

## 🗂 Estrutura do Projeto

```
crud-mundo/
│
├── frontend/
│   ├── index.html
│   ├── pais.html
│   ├── cidade.html
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   └── assets/
│       └── (imagens, ícones)
│
├── backend/
│   ├── conexao.php
│   ├── pais/
│   │   ├── criar.php
│   │   ├── listar.php
│   │   ├── editar.php
│   │   └── excluir.php
│   └── cidade/
│       ├── criar.php
│       ├── listar.php
│       ├── editar.php
│       └── excluir.php
│
├── database/
│   └── bd_mundo.sql
│
└── README.md
```

---

## 🗃 Banco de Dados

### Tabelas:

#### `paises`
| Campo        | Tipo         | Descrição               |
|--------------|--------------|-------------------------|
| id_pais      | INT (PK)     | Identificador único     |
| nome         | VARCHAR(100) | Nome oficial do país    |
| continente   | VARCHAR(50)  | Continente              |
| populacao    | INT          | População total         |
| idioma       | VARCHAR(50)  | Idioma principal        |

#### `cidades`
| Campo        | Tipo         | Descrição               |
|--------------|--------------|-------------------------|
| id_cidade    | INT (PK)     | Identificador único     |
| nome         | VARCHAR(100) | Nome da cidade          |
| populacao    | INT          | População da cidade     |
| id_pais      | INT (FK)     | Referência ao país      |

---

## ⚙️ Como Executar o Projeto

### Pré-requisitos:
- Servidor web (ex: XAMPP, WAMP)
- PHP 7.4+
- MySQL 5.7+

### Passos:

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/seu-usuario/crud-mundo.git
   ```

2. **Configure o banco de dados:**
   - Importe o arquivo `database/bd_mundo.sql` no phpMyAdmin ou via linha de comando.

3. **Configure a conexão com o BD:**
   - Edite o arquivo `backend/conexao.php` com suas credenciais do MySQL.

4. **Coloque os arquivos na pasta do servidor:**
   - Ex: `C:\xampp\htdocs\crud-mundo`

5. **Acesse no navegador:**
   ```
   http://localhost/crud-mundo/frontend/index.html
   ```

---

## 📌 Funcionalidades

### Principais:
- ✅ Cadastro de países e cidades
- ✅ Listagem com busca dinâmica
- ✅ Edição e exclusão com confirmação
- ✅ Validação de formulários no front-end e back-end
- ✅ Integração com APIs externas

### Extras (Opcionais):
- 🔍 Busca dinâmica por nome
- 📊 Estatísticas (ex: cidade mais populosa)
- 🌤 Clima em tempo real por cidade

---

## 👨‍💻 Autor

**Victor Diniz Bento**  
📧 Email: vcr.dnz@gmail.com
🔗 GitHub: [VictorDnzb](https://github.com/VictorDnzb)

---

## 📄 Licença

Este projeto é destinado para fins educacionais.

---
