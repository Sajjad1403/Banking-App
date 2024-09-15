# Small Banking Application

A simple banking application built using the Laravel PHP framework. This application provides basic banking functionalities including account management, cash transactions, and account statements.

## Features

1. **Registration**  
   Create a new account with an email ID and password.

2. **Login**  
   Authenticate users to access their accounts.

3. **Inbox/Home**  
   Display account information on the home page.

4. **Cash Deposit**  
   Deposit a specified amount into the logged-in account.

5. **Cash Withdrawal**  
   Withdraw a specified amount from the logged-in account.

6. **Cash Transfer**  
   Transfer funds from the logged-in account to another account using an email ID.

7. **Account Statement**  
   View transaction history and account statements.

8. **Logout**  
   Securely log out from the account.

## Requirements

- PHP 8.x
- Laravel 11.x
- Composer
- MySQL or another supported database

## Installation

1. **Clone the Repository**  
   ```bash
   git clone https://github.com/Sajjad1403/Banking-App.git
   cd Banking-App

Install Dependencies
composer install

Set Up Environment
cp .env.example .env

Generate Application Key
php artisan key:generate

Run Migrations
php artisan migrate


Start the Development Server
php artisan serve
