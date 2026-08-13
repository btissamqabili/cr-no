# Creno

Application Laravel de gestion et de réservation de créneaux.

## 1. Présentation du projet

Creno est une application web développée avec Laravel permettant à un client de réserver un créneau en ligne et à un administrateur de gérer les créneaux disponibles.

L'objectif principal du projet est de garantir la fiabilité des réservations et d'empêcher les doubles réservations ou les réservations invalides.

### Fonctionnalités principales

- Inscription et connexion des utilisateurs
- Gestion des rôles : `client` et `administrateur`
- Consultation des créneaux disponibles
- Réservation d'un créneau
- Consultation des rendez-vous du client
- Annulation de ses propres rendez-vous
- Gestion des créneaux par l'administrateur
- Protection des routes administrateur
- Tests automatisés avec PHPUnit

---

## 2. Technologies utilisées

- PHP
- Laravel
- Laravel Breeze
- Blade
- Eloquent ORM
- SQLite pour les tests
- PHPUnit
- Factory Laravel
- Git / GitHub

---

## 3. Prérequis

Avant d'installer le projet, il faut avoir :

- PHP 8.3 ou supérieur
- Composer
- Node.js et npm
- MySQL/MariaDB ou SQLite
- Git

Vérifier les versions :

```bash
php -v
composer -V
node -v
npm -v