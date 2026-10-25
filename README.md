# 🛍️ URBÆ - Plataforma de E-commerce Urbana

> **Projeto de Aptidão Profissional (PAP)** | Curso Técnico de Gestão e Programação de Sistemas Informáticos (Escola Secundária Avelar Brotero)  
> **Classificação:** 19/20  

---

## 📌 Visão Geral

O **URBÆ** é uma plataforma de e-commerce completa voltada para o vestuário urbano, desenvolvida de raiz em **PHP nativo**, **MySQL** e **JavaScript**. O projeto integra um assistente inteligente alimentado pela **API do Google Gemini**, mecanismos de autenticação e gestão de permissões, geração automática de faturas em PDF e integração de envio de e-mails transacionais.

---

## 🚀 Principais Funcionalidades

### 🛒 Front-End & Loja
- **Catálogo Dinâmico:** Visualização e filtragem de produtos por categoria, género e stock.
- **Carrinho & Checkout:** Gestão de itens em tempo real com simulação de pagamentos.
- **Assistente de IA Integrado:** Chat com o Google Gemini para apoio à escolha de produtos e atendimento ao cliente.
- **Suporte Multilingue:** Suporte para múltiplos idiomas (Português e Inglês).

### ⚙️ Back-End & Painel Administrativo
- **Gestão de Inventário & Produtos:** CRUD completo para inserção, edição e remoção de catálogo.
- **Gestão de Utilizadores & Permissões:** Sistema de perfis com controlo de acesso por níveis (Cliente vs Admin).
- **Faturação Automática:** Emissão dinâmica de faturas em formato PDF via mPDF.
- **E-mails Transacionais:** Confirmações de conta e operações enviadas via PHPMailer.

---

## 🛠️ Tecnologias Utilizadas

- **Linguagens:** PHP (Nativo), JavaScript (ES6+), HTML5, CSS3
- **Base de Dados:** MySQL / MariaDB (com integridade referencial e triggers)
- **APIs & Bibliotecas:** 
  * Google Gemini API (Assistente virtual)
  * mPDF (Geração de PDFs)
  * PHPMailer (Envio de e-mails)
- **Ambiente de Desenvolvimento:** XAMPP (Apache + MySQL)

---

## 📐 Arquitetura & Base de Dados

O esquema relacional do banco de dados foi projetado para suportar relações de **1:N** e **N:M** (ex: utilizadores, encomendas, itens da encomenda, produtos e categorias), garantindo consistência através de *Foreign Keys* e integridade referencial.

---

## 📄 Documentação

## 📄 Documentação

O relatório técnico completo da Prova de Aptidão Profissional (PAP), detalhando a análise de requisitos, diagramas de UML/ER e decisões de arquitetura, está disponível no ficheiro [`Relatório Técnico (DOCX)`](./Relatório%20da%20pap%20Ruben%20paulino%2012PSI1%20N15.docx).

---
