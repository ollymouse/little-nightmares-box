# Little Nightmares Box

Um espaço para registrar sua jornada pelo universo sombrio de Little Nightmares!

## 📖 Sobre o projeto

O **Little Nightmares Box** é um projeto acadêmico desenvolvido como critério avaliativo na disciplina de **Banco de Dados II**, durante o segundo ano do curso técnico de Desenvolvimento de Sistemas.

A proposta consiste no desenvolvimento de um site inspirado no universo da franquia *Little Nightmares*, permitindo que jogadores registrem suas jornadas, acompanhem seus progressos e explorem informações relacionadas aos personagens, capítulos, locais e itens colecionáveis dos jogos.

O projeto integra desenvolvimento web com banco de dados relacional, utilizando PHP para a comunicação entre a aplicação e o banco de dados MySQL.

## Funcionalidades

- **Cadastro de usuários:** criação de contas com nome, e-mail e apelido.
- **Login:** acesso ao sistema utilizando o e-mail cadastrado.
- **Página principal:** visualização do progresso atual e do histórico de progressos concluídos.
- **Colecionáveis:** consulta dos itens colecionáveis cadastrados.
- **Locais:** visualização dos locais relacionados aos colecionáveis.
- **Registro de progresso:** possibilidade de iniciar um novo progresso selecionando um capítulo e um item colecionável.
- **Sessões de usuário:** controle de acesso às páginas internas do sistema.

##  Tecnologias utilizadas

| Tecnologia | Aplicação |
|---|---|
| HTML5 | Estrutura das páginas |
| CSS3 | Estilização e identidade visual |
| JavaScript | Recursos e elementos visuais |
| PHP | Processamento e integração com o banco de dados |
| MySQL | Armazenamento e gerenciamento dos dados |

## Banco de dados

O projeto utiliza o MySQL para armazenar e relacionar as informações da aplicação.

O banco de dados `littlenightmaresbox` possui seis tabelas principais:

- **jogador:** armazena os dados dos usuários cadastrados.
- **personagem:** registra informações dos personagens.
- **capitulo:** armazena os capítulos relacionados aos personagens.
- **colecionavel:** registra os itens colecionáveis.
- **local:** armazena os locais associados aos colecionáveis.
- **progresso:** registra os avanços dos jogadores durante o jogo.

O banco utiliza chaves primárias, chaves estrangeiras, relacionamentos e restrições de integridade referencial.

### Modelagem do banco de dados

Os modelos conceitual e lógico foram desenvolvidos durante a elaboração do projeto.

**MER — Modelo Entidade-Relacionamento**

![Modelo Entidade-Relacionamento](MER&DER/MER.png)

**DER — Diagrama Entidade-Relacionamento**

![Diagrama Entidade-Relacionamento](MER&DER/DER.png)

Os arquivos editáveis dos diagramas também estão disponíveis na pasta `MER&DER`.

## Estrutura do projeto

```text
LittleNightmaresBox/
│
├── css/
│   ├── cadastroUsuario.css
│   ├── colecionavel.css
│   ├── index.css
│   ├── local.css
│   ├── loginUsuario.css
│   ├── main.css
│   └── style.css
│
├── images/
│   └── Arquivos de imagens e backgrounds
│
├── js/
│   └── indexBackground.js
│
├── font/
│   └── Fontes utilizadas no projeto
│
├── php/
│   ├── cadastrarusuario.php
│   ├── colecionaveis.php
│   ├── conexao.php
│   ├── detalhe_colecionavel.php
│   ├── locais.php
│   ├── loginusuario.php
│   ├── logout.php
│   ├── main.php
│   └── novo_progresso.php
│
├── db/
│   └── littlenightmaresbox.sql
│
├── index.html
│
└── MER&DER/
    ├── MER.png
    ├── DER.png
    ├── MER.brM3
    └── DER.brM3
```

## ⚙️ Como executar o projeto

Para executar o projeto localmente, é necessário possuir:

- PHP instalado.
- Servidor MySQL.
- Servidor web local, como XAMPP ou Apache com PHP.

### 1. Clone o repositório

```bash
git clone https://github.com/ollymouse/little-nightmares-box.git
```

### 2. Configure o banco de dados

Crie o banco de dados importando o arquivo:

```text
db/littlenightmaresbox.sql
```

O script contém a estrutura das tabelas e seus relacionamentos.

### 3. Configure a conexão

Abra o arquivo:

```text
php/conexao.php
```

Configure as credenciais de acordo com seu ambiente MySQL.

### 4. Execute o projeto

Coloque a pasta do projeto no diretório público do seu servidor local e inicie os serviços Apache e MySQL.

Acesse pelo navegador:

```text
http://localhost/LittleNightmaresBox/
```

## Contexto acadêmico

**Disciplina:** Banco de Dados II

**Curso:** Técnico em Desenvolvimento de Sistemas

**Tipo:** Projeto acadêmico avaliativo

O desenvolvimento teve como objetivo aplicar conhecimentos de modelagem de dados, criação de tabelas, relacionamentos, integridade referencial e integração entre banco de dados e aplicações web.

---

Desenvolvido como projeto acadêmico de Desenvolvimento de Sistemas.
