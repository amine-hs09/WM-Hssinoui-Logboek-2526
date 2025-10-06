Individuele oefening RESTful API (Oef1)
👤 Student

Naam: Mohamed Amine Hssinoui

Opleiding: Toegepaste Informatica – Odisee

Vak: Web & Mobile (OBI44a)

Oefening: Individuele oefening RESTful API (Concert Tickets)

Deadline: 12/10/2025 – 23:59

🎯 Doel van de oefening

Een RESTful API maken waarmee bezoekers tickets kunnen kopen voor concerten.
De oefening bestaat uit twee delen:

PHP API (backend): concerten, bezoekers en tickets CRUD-operaties.

HTML/JS webapp (frontend): data ophalen via fetch() en tonen in de browser.

🧱 Structuur van het project
/www/oef1/
├─ api/
│  ├─ .htaccess
│  ├─ base.php
│  ├─ concerts.php
│  ├─ visitors.php
│  ├─ tickets.php
│  ├─ inc/
│  │  ├─ dbcon.php
│  │  └─ helpers.php
└─ webapp/
   ├─ index.html
   └─ script.js

💾 Database (Combell)

Host: ID477568_Restfulapi.db.webhosting.be

Database: ID477568_Restfulapi

User: ID477568_Restfulapi

Pass: (privé in inc/dbcon.php)

Tabellen:

concerts → artiest, datum, uur, locatie, prijs

visitors → voornaam, familienaam, geboortedatum, email

tickets → link tussen bezoekers en concerten

De database bevat realistische testdata (Angèle, Damso, Dua Lipa, Ed Sheeran, Coldplay, enz.).  die werden gemaakt met chat gpt via het website https://www.livenation.be/ 
