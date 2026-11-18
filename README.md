#  Sistema Prisional - Gestão de Detentos

Sistema web desenvolvido para a disciplina de Desenvolvimento Web (HTML5, CSS3, JavaScript e PHP), com o objetivo de gerenciar detentos, celas e visitas de forma segura e integrada a um banco de dados relacional.

Grupo: 
-Fabrício sobreira(202601772856) -> HTML + CSS
-Victor de Souza(202603195988) -> PHP + JS + Segurança
-João Gabriel(2026603180964) -> SQL


---

##Tecnologias Utilizadas

* **Front-end:** HTML5, CSS3 e JavaScript (com manipulação de DOM e validação de formulários).
* **Back-end:** PHP (processamento de dados via rotinas estruturadas).
* **Banco de Dados:** MySQL (utilizando PDO com *Prepared Statements* para máxima segurança contra SQL Injection)
* **Ambiente de Execução:** XAMPP (Apache e MySQL).

---

## Requisitos de Segurança Implementados

* **Proteção contra SQL Injection:**
* **Proteção contra XSS (Cross-Site Scripting):**
* **Validação em Camadas:**

---

## Como Instalar e Executar o Projeto

Para rodar o sistema localmente na sua máquina, siga os passos abaixo:

### 1. Pré-requisitos
* Ter o **XAMPP** instalado no computador (com os módulos **Apache** e **MySQL** ativos).

### 2. Clonar ou Mover o Projeto
* Coloque a pasta inteira do projeto (ex: `DevWebPronto`) dentro do diretório público do servidor local do XAMPP:
  * **Windows:** `C:\xampp\htdocs\`

### 3. Configurar o Banco de Dados
1. Abra o painel do XAMPP e clique em **Start** no **Apache** e no **MySQL**.
2. No navegador, acesse o painel do gerenciador de banco de dados: `http://localhost/phpmyadmin`
3. Crie um banco de dados ou importe o arquivo de estrutura (`banco.sql`) fornecido no repositório através da aba **Importar**.

### 4. Acessar a Aplicação
Com os serviços rodando e o banco importado, abra o seu navegador e acesse o endereço:
```text
http://localhost/DevWebPronto/login.php
