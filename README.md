# CoFi – Gestione Finanziaria Familiare

[![Laravel](https://img.shields.io/badge/Laravel-12-red)](https://laravel.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-blue)](https://getbootstrap.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2-blueviolet)](https://www.php.net/)

---

## Descrizione
**CoFi** è una web app per la gestione finanziaria familiare.  
Permette a una famiglia di tracciare entrate, spese e budget, con la possibilità di aggiungere membri e gestire autorizzazioni.  
Il progetto è pensato per essere **elegante, sicuro e collaborativo**, con un’interfaccia pulita e colori pastello.

**Caratteristiche principali:**
- Registrazione e login sicuri tramite email e password
- Codice unico per ogni famiglia per gestire l’accesso dei membri
- Ruoli: `admin` generale (gestisce solo utenti e statistiche globali) e membri della famiglia
- Dashboard per controllare entrate, spese e membri
- GDPR-compliant e protezione della privacy
- Design responsive con Bootstrap 5

---

## Tecnologie utilizzate
- **Backend:** Laravel 12, PHP 8.2  
- **Frontend:** Blade Templates + Bootstrap 5  
- **Database:** MySQL  
- **Autenticazione:** Laravel Breeze / Auth  
- **Gestione pacchetti:** npm + Vite

---

## Installazione
1. Clona il repository:
   ```bash
   git clone https://github.com/tuo-username/cofi.git
   cd cofi


2. Installa le dipendenze PHP:
    ```bash
    composer install


3. Installa le dipendenze JS:
    ```bash
    npm install


4. Configura il file .env (database, email, chiavi segrete):

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=cofi
    DB_USERNAME=root
    DB_PASSWORD=


5. Genera la chiave dell’app:
    ```bash
    php artisan key:generate


6. Esegui migrazioni e seed:
    ```bash
    php artisan migrate --seed


Il seed crea un utente admin predefinito:

Email: admin@cofi.com

Password: admin123

7. Avvia il server di sviluppo:
    ```bash
    php artisan serve
    npm run dev

Struttura del progetto
app/
├─ Http/
│  ├─ Controllers/
│  │  ├─ Auth/        # Login, Register, Reset password
│  │  └─ AdminController.php
│  └─ Middleware/
│     └─ AdminMiddleware.php
resources/
├─ views/
│  ├─ layout/
│  │  ├─ app.blade.php
│  │  ├─ navbar.blade.php
│  │  └─ footer.blade.php
│  ├─ auth/           # Login, Register, Forgot password, etc.
│  ├─ admin/          # Dashboard admin
│  └─ user/           # Dashboard famiglia
├─ css/
│  └─ app.css
├─ js/
│  └─ app.js
routes/
├─ web.php
database/
├─ migrations/
├─ seeders/

8. Utilizzo:

    Accedi come utente admin → /admin/dashboard

    Accedi come utente famiglia → registrati e ricevi un codice famiglia

    Aggiungi membri e traccia le spese dalla dashboard

    Stile e design

    Colori pastello eleganti, predominanza di blu pastello

    Layout centrato e responsive

    Pulsanti e card armonizzate per leggibilità e UX

    Licenza

    MIT License © 2025 Vito Strisciuglio

    Contatti

    Per dubbi o contributi: vitostri89@gmail.com
