Naam: RESTful API – Concert Tickets
Student: Mohamed Amine Hssinoui
Opleiding: Toegepaste Informatica – Odisee Hogeschool
Vak: Web & Mobile

Belangrijke links
Online webapp
punten

Opgave

In deze individuele oefening bouw ik een volledig werkende RESTful API met PHP en MySQL, inclusief CRUD-operaties (Create, Read, Update, Delete).

De toepassing laat bezoekers toe om tickets voor concerten te kopen.
De API wordt online gehost op Combell en getest via Postman.

/www/oef1/api/
│
├── base.php                  → JSON + CORS helper functies
├── dbcon.php                 → MySQL-verbinding (Combell)
├── .htaccess                 → rewrite rules voor mooie URL's
├── concerts.php              → router (GET, POST, PUT, DELETE)
│
└── /inc/concerts/
    ├── add.php               → POST – concert toevoegen
    ├── get.php               → GET – lijst + details van concerten
    ├── update.php            → PUT – concert wijzigen
    └── delete.php            → DELETE – concert verwijderen

💾 Database (Combell)

Naam: ID477568_Restfulapi
Tabel: concerts
Tabellen:

concerts (id, artist, date, time, venue, price)

visitors (id, first_name, last_name, birth_date, email)

tickets (id, visitor_id, concert_id, qty)

De database bevat realistische data (Angèle, Hamza, PNL …) voor de test. die komen uit het website die we gekregen hebben 

🌐 Online links
Beschrijving	
API live op Combell	🔗 https://www.mohamedaminehssinoui-odisee.be/oef1/api/concerts.php

🧪 Testen via Postman
GET — lijst van alle concerten
GET https://www.mohamedaminehssinoui-odisee.be/oef1/api/concerts.php


✅ Resultaat:

{
  "code": 1,
  "status": 200,
  "data": [
    { "id": 4, "artist": "Ed Sheeran", "date": "2026-03-28", "time": "19:45:00", "venue": "King Baudouin Stadium, Brussels", "price": "120.00" }
  ]
}

GET — details van één concert
GET https://www.mohamedaminehssinoui-odisee.be/oef1/api/concerts.php?id=4

POST — nieuw concert toevoegen
{
  "artist": "Dua Lipa",
  "date": "2025-12-01",
  "time": "20:00:00",
  "venue": "Forest National",
  "price": 89.50
}

PUT — concert aanpassen
{
  "id": 19,
  "artist": "The Weeknd",
  "date": "2026-03-12",
  "time": "20:00:00",
  "venue": "Forest National, Brussels",
  "price": 130.00
}

DELETE — concert verwijderen
{ "id": 19 }


📅 Werkplanning (zoals logboek)
Datum	Activiteit
Zat 04/10	Database aangemaakt (concerts + testdata) op Combell. Eerste versie van dbcon.php en base.php.
Zon 05/10	concerts.php router gemaakt met switch (GET/POST/PUT/DELETE). GET getest via Postman.
Ma 06/10	add.php toegevoegd (POST). Test via Postman succesvol (Dua Lipa toegevoegd).
Di 07/10	update.php geschreven en getest (update van The Weeknd).
Woe 08/10	delete.php getest – concert wordt correct verwijderd uit database.
