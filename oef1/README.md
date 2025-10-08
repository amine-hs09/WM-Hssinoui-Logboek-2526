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
├── base.php → JSON + CORS helper functies
├── dbcon.php → MySQL-verbinding (Combell)
├── .htaccess → rewrite rules voor mooie URL's
├── concerts.php → router (GET, POST, PUT, DELETE)
│
└── /inc/concerts/
├── add.php → POST – concert toevoegen
├── get.php → GET – lijst + details van concerten
├── update.php → PUT – concert wijzigen
└── delete.php → DELETE – concert verwijderen

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
API live op Combell 🔗 https://www.mohamedaminehssinoui-odisee.be/oef1/api/concerts.php

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
Datum Activiteit
Zat 04/10 Database aangemaakt (concerts + testdata) op Combell. Eerste versie van dbcon.php en base.php.
Zon 05/10 concerts.php router gemaakt met switch (GET/POST/PUT/DELETE). GET getest via Postman.
Ma 06/10 add.php toegevoegd (POST). Test via Postman succesvol (Dua Lipa toegevoegd).
Di 07/10 update.php geschreven en getest (update van The Weeknd).
Woe 08/10 delete.php getest – concert wordt correct verwijderd uit database.

Deel 2 – Tickets API
/www/oef1/api/
│
├── tickets.php → hoofd-router (GET / POST / PUT / DELETE)
├── base.php → JSON-helpers + CORS + validaties
├── dbcon.php → database-verbinding (MySQLi)
│
└── /inc/tickets/
├── add.php → POST : nieuw ticket kopen
├── get.php → GET : tickets ophalen
├── update.php → PUT : ticket wijzigen
└── delete.php → DELETE : ticket verwijderen

https://www.mohamedaminehssinoui-odisee.be/oef1/api/tickets.php

Database : ID477568_Restfulapi
Tabel : tickets
1️⃣ GET – Alle tickets ophalen

Methode : GET
URL :

https://www.mohamedaminehssinoui-odisee.be/oef1/api/tickets.php

📤 Voorbeeld-response :

{
"data": [
{
"id": 1,
"first_name": "Amine",
"last_name": "Hssinoui",
"artist": "Angèle",
"venue": "Forest National, Brussels",
"qty": 2
}
],
"status": 200
}

2️⃣ GET – Eén ticket ophalen

Methode : GET
URL :

https://www.mohamedaminehssinoui-odisee.be/oef1/api/tickets.php?id=1

📤 Voorbeeld-response :

{
"data": {
"id": 1,
"first_name": "Amine",
"last_name": "Hssinoui",
"artist": "Angèle",
"venue": "Forest National, Brussels",
"qty": 2,
"bought_at": "2025-10-06 12:43:44"
},
"status": 200
}

📝 Opmerking : de parameter id verwijst naar het ticketnummer, niet naar visitor_id.

3️⃣ POST – Nieuw ticket aanmaken

Methode : POST
URL :

https://www.mohamedaminehssinoui-odisee.be/oef1/api/tickets.php

Headers :

Content-Type: application/json

Body (JSON) :

{
"visitor_id": 2,
"concert_id": 3,
"qty": 2
}

📤 Voorbeeld-response :

{
"data": "ok",
"message": "Ticket purchased successfully",
"status": 200,
"id": 10
}

4️⃣ PUT – Ticket aanpassen

Methode : PUT
URL :

https://www.mohamedaminehssinoui-odisee.be/oef1/api/tickets.php

Body (JSON) :

{
"id": 10,
"qty": 3
}

📤 Voorbeeld-response :

{
"data": "ok",
"message": "Ticket updated",
"status": 200,
"updated": 1
}

5️⃣ DELETE – Ticket verwijderen

Methode : DELETE
URL :

https://www.mohamedaminehssinoui-odisee.be/oef1/api/tickets.php

Body (JSON) :

{
"id": 10
}

Voorbeeld-response :

{
"data": "ok",
"message": "Ticket deleted",
"status": 200,
"deleted": 1
}

Parfait Amine 👌 — voici ton **README complet (Deel 3 + Deel 4)**
en **Nederlands**, prêt à coller directement dans ton fichier `README.md`.
Il respecte exactement la structure de tes voorgaande delen (Concerts + Tickets).

---

## 📘 Deel 3 – Visitors API
08/10/25

### 🎯 Doel

Deze API maakt het mogelijk om bezoekers (**visitors**) te beheren.
Je kan bezoekers toevoegen, opvragen, wijzigen en verwijderen via RESTful endpoints.

De tabel **visitors** bevat volgende velden:

- `id` (int, auto_increment)
- `first_name` (varchar 80)
- `last_name` (varchar 80)
- `birth_date` (date)
- `email` (varchar 120, uniek)
- `created_at` (timestamp)

---

### ⚙️ Endpoints

| Methode  | Endpoint                    | Beschrijving                                 |
| -------- | --------------------------- | -------------------------------------------- |
| `GET`    | `/api/visitors.php`         | geeft alle bezoekers terug                   |
| `GET`    | `/api/visitors.php?id={id}` | geeft één specifieke bezoeker + zijn tickets |
| `POST`   | `/api/visitors.php`         | voegt een nieuwe bezoeker toe                |
| `PUT`    | `/api/visitors.php`         | wijzigt een bestaande bezoeker               |
| `DELETE` | `/api/visitors.php`         | verwijdert een bezoeker op basis van id      |

---

### 🧪 Test 1 – Nieuwe visitor toevoegen

**POST →**
`https://www.mohamedaminehssinoui-odisee.be/oef1/api/visitors.php`

**Body (JSON):**

```json
{
  "first_name": "Nadia",
  "last_name": "Lefevre",
  "birth_date": "1996-03-22",
  "email": "nadia.lefevre@example.com"
}
```

**Response:**

```json
{
  "data": "ok",
  "message": "Record added successfully",
  "status": 200,
  "id": 9
}
```

---

### 🧪 Test 2 – Visitor aanpassen

**PUT →**
`https://www.mohamedaminehssinoui-odisee.be/oef1/api/visitors.php`

**Body (JSON):**

```json
{
  "id": 9,
  "first_name": "Nadia",
  "last_name": "Lefevre",
  "birth_date": "1996-03-22",
  "email": "nadia.lefevre@update.com"
}
```

**Response:**

```json
{
  "data": "ok",
  "message": "Record updated",
  "status": 200,
  "updated": 1
}
```

---

### 🧪 Test 3 – Visitor verwijderen

**DELETE →**
`https://www.mohamedaminehssinoui-odisee.be/oef1/api/visitors.php`

**Body (JSON):**

```json
{ "id": 9 }
```

**Response:**

```json
{
  "data": "ok",
  "message": "Record deleted",
  "status": 200,
  "deleted": 1
}
```

---

### 🧩 Samenvatting

| Test     | Actie                       | Verwachte resultaat | Status |
| -------- | --------------------------- | ------------------- | ------ |
| POST     | Nieuwe visitor toegevoegd   | ✅                  |        |
| PUT      | Visitor aangepast           | ✅                  |        |
| DELETE   | Visitor verwijderd          | ✅                  |        |
| GET (id) | Visitor + tickets opgehaald | ✅                  |        |

---

## 📘 Deel 4 – Relatie tussen Visitors en Concerts via Tickets API

datum 08/10/25
### 🎯 Doel

In deze stap werd getest dat één bezoeker (**visitor**) meerdere concerten kan bijwonen,
en dat één concert meerdere bezoekers kan hebben.

Dit bevestigt de **many-to-many-relatie** tussen _visitors_ en _concerts_,
gerealiseerd door de tabel **tickets**.

---

### 🧩 Database-structuur

| Tabel      | Omschrijving                                                                        |
| ---------- | ----------------------------------------------------------------------------------- |
| `visitors` | gegevens van de bezoekers (voornaam, naam, geboortedatum, e-mail)                   |
| `concerts` | gegevens van de concerten (artiest, datum, uur, locatie, prijs)                     |
| `tickets`  | koppeltabel tussen visitors ↔ concerts met velden `visitor_id`, `concert_id`, `qty` |

✅ Een visitor kan meerdere tickets kopen voor verschillende concerten.
✅ Een concert kan door meerdere visitors gekocht worden.

---

### ⚙️ Endpoints

| Methode | Endpoint                    | Beschrijving                                                      |
| ------- | --------------------------- | ----------------------------------------------------------------- |
| `POST`  | `/api/tickets.php`          | maakt een nieuw ticket aan (= bezoeker koopt concert)             |
| `GET`   | `/api/visitors.php?id={id}` | toont de bezoeker en alle concerten waarvoor tickets zijn gekocht |
| `GET`   | `/api/concerts.php?id={id}` | toont een concert met alle bezoekers die een ticket hebben        |

---

### 🧪 Test 1 – Bezoeker koopt ticket voor nieuw concert

**POST →**
`https://www.mohamedaminehssinoui-odisee.be/oef1/api/tickets.php`

```json
{
  "visitor_id": 2,
  "concert_id": 5,
  "qty": 2
}
```

**Response:**

```json
{
  "data": "ok",
  "message": "Record added successfully",
  "status": 200,
  "id": 10
}
```

---

### 🧪 Test 2 – Dezelfde visitor koopt ander concert

```json
{
  "visitor_id": 2,
  "concert_id": 9,
  "qty": 1
}
```

**Response:**

```json
{
  "data": "ok",
  "message": "Record added successfully",
  "status": 200,
  "id": 11
}
```

➡ Visitor 2 heeft nu tickets voor twee verschillende concerten.

---

### 🧪 Test 3 – Andere visitor voor hetzelfde concert

```json
{
  "visitor_id": 3,
  "concert_id": 5,
  "qty": 3
}
```

**Response:**

```json
{
  "data": "ok",
  "message": "Record added successfully",
  "status": 200,
  "id": 12
}
```

➡ Concert 5 heeft nu meerdere bezoekers.

---

### 🧪 Controle – GET Visitor met al zijn concerten

**GET →**
`https://www.mohamedaminehssinoui-odisee.be/oef1/api/visitors.php?id=2`

**Response:**

```json
{
  "data": {
    "visitor": {
      "id": 2,
      "first_name": "Ilias",
      "last_name": "El Gatri",
      "email": "ilias.elgatri@example.com"
    },
    "tickets": [
      {
        "artist": "Imagine Dragons",
        "venue": "Sportpaleis, Antwerp",
        "date": "2026-04-17",
        "qty": 2
      },
      {
        "artist": "The 1975",
        "venue": "Lotto Arena, Antwerp",
        "date": "2026-01-19",
        "qty": 1
      }
    ]
  },
  "status": 200
}
```

✅ Toont dat één visitor tickets heeft voor meerdere concerten.

---

### 🧩 Samenvatting

| Test | Actie                             | Verwachte resultaat              | Status |
| ---- | --------------------------------- | -------------------------------- | ------ |
| 1    | Visitor 2 koopt concert 5         | Ticket toegevoegd                | ✅     |
| 2    | Visitor 2 koopt concert 9         | Tweede ticket toegevoegd         | ✅     |
| 3    | Visitor 3 koopt concert 5         | Concert heeft meerdere bezoekers | ✅     |
| 4    | GET visitor → toon alle concerten | Werkt correct (many-to-many)     | ✅     |


