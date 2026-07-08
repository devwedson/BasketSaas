# Especificação do Sistema SaaS de Gestão de Basquete

## Objetivo

Sistema web em Laravel + MySQL para gestão de clubes, treinadores,
equipes, atletas, treinos, jogos e estatísticas.

para a landpage use E:\Basket-F\neodunk e para qual quer outra pagina que for ser criada na landpage use dai
e para dashboard ou paginas novas etc deve usar ela E:\Basket-F\attex

## Stack

-   Laravel 12
-   PHP 8.3+
-   MySQL 8
-   Blade ou Vue.js
-   Bootstrap/Tailwind
-   Redis (opcional)
-   Filas (opcional)

# Perfis

-   Super Administrador
-   Clube
-   Treinador
-   Auxiliar
-   Atleta (portal)
-   Responsável

# Funcionalidades

## Dashboard

-   Indicadores
-   Próximos treinos
-   Próximos jogos
-   Atletas ativos

## Clubes

-   Cadastro
-   Logo
-   Endereço
-   Contatos

## Times

-   Categoria
-   Temporada
-   Comissão técnica
-   Uniforme

## Jogadores

-   Dados pessoais
-   Foto
-   Posição
-   Número
-   Altura
-   Peso
-   Responsável
-   Documentos

## Comissão Técnica

-   Técnicos
-   Auxiliares
-   Preparador físico
-   Fisioterapeuta

## Treinos

-   Agenda
-   Exercícios
-   Presença
-   Observações

## Jogos

-   Adversário
-   Local
-   Data
-   Placar
-   Escalação

## Estatísticas

-   Pontos
-   Rebotes
-   Assistências
-   Roubos
-   Tocos
-   Turnovers
-   Faltas
-   Minutos
-   Arremessos (FG, 3PT, FT)

## Calendário

-   Jogos
-   Treinos
-   Eventos

## Lesões

-   Histórico
-   Situação
-   Retorno

## Avaliações Físicas

-   Peso
-   Altura
-   Salto
-   Velocidade
-   Resistência

## Financeiro

-   Receitas
-   Despesas
-   Mensalidades

## Documentos

-   Contratos
-   Atestados
-   RG/CPF

## Relatórios

-   PDF
-   Excel

# Banco de Dados

users clubs teams players staff seasons games game_stats trainings
training_attendance injuries physical_assessments documents
financial_transactions

# MVP

1.  Login
2.  Clubes
3.  Times
4.  Jogadores
5.  Comissão Técnica
6.  Treinos
7.  Jogos
8.  Estatísticas
9.  Calendário
10. Relatórios

> Fora do escopo: - IA - Notificações - WhatsApp - Push - E-mail
> automático
