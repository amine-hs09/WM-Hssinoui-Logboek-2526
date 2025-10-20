# WM-Hssinoui-Logboek-2526
# WM-Hssinoui-Logboek-2526

Dit is het logboek voor het vak **Web & Mobile (OBI44a)** van het academiejaar 2025-2026.

Student: **Mohamed Amine Hssinoui**  
Opleiding: **Toegepaste Informatica – Odisee**

---

## Inhoud
- `logboek.md` : overzicht per week van de activiteiten, tijdsbesteding en vooruitgang.  
- Extra bestanden (indien nodig) komen later hier in de repository.

---

## Doel
Het logboek dient om:
- Alle activiteiten, oefeningen en projecten bij te houden.  
- Een overzicht te geven van de tijd en inspanningen per week.  
- Transparantie te hebben in mijn leerproces.  

---

## Contact docent
- Steven Ophalvens  
- Frank Salliau

hssinoui mohamed amine 

## Week 1 – Startproject & omgeving
📅 **Datum:** 29 september 2025  
⏱️ **Tijd:** ± 2 uur  
🧠 **Wat gedaan:**
- XAMPP geïnstalleerd en MySQL + Apache geconfigureerd.  
- Eerste lokale testpagina (`helloOdisee.php`) gemaakt en getest in browser.  
- Begonnen met `les1`  

## Week 2 – FTP en hosting (Combell)
📅 **Datum:** 30 september – 1 oktober 2025  
⏱️ **Tijd:** ± 5 uur  
🧠 **Wat gedaan:**
- FileZilla geïnstalleerd en verbinding gemaakt met **Combell FTP**.  
- Nieuwe site aangemaakt: `ftp.mohamedaminehssinoui-odiseebe.webhosting.be`.  
- Correcte mapstructuur opgezet: `/www/les1/css`, `/www/les1/inc`, `/www/les1/php`.  
- Testbestanden (`helloOdisee.php`, `helloData.php`, `fibi.php`) online gezet.  
- Succesvol getest via de URL :  


## Week 3 – Databaseverbinding (Combell MySQL)
📅 **Datum:** 2 oktober 2025  
⏱️ **Tijd:** ± 3 uur  
🧠 **Wat gedaan:**
- Database php admin   
- Verbinding getest met PHP-bestand `/inc/db.php`.  
- Variabelen `$servername`, `$username`, `$password`, `$dbname` correct ingevuld.  
- Databaseconnectie geslaagd 

## les 4 – Oefening 2 (producten & categorieën)
📅 **Datum:** 3 – 4 oktober 2025  
⏱️ **Tijd:** ± 6 uur  
🧠 **Wat gedaan:**
- Tabellen aangemaakt in phpMyAdmin:
  - **categorieen** (ct_id, ct_naam)  
  - **producten** (pr_id, pr_naam, pr_prijs, pr_ct_id)
- Testdata toegevoegd.  
- PHP-pagina gemaakt om producten + categorieën te tonen met **JOIN** (`producten.php`).  
- Formulier gemaakt om nieuwe producten toe te voegen (**INSERT**) → `product_add.php`.  
- Formulier voor aanpassingen (**UPDATE**) → `product_edit.php`.  
https://mohamedaminehssinoui-odisee.be/les1/php/producten.php  


## 6 oktober 2025 

⏱️ **Tijd:** ± 4 uur  
🧠 **Wat gedaan:**
begonnen met mijn porject 
maken van db en het aanmaken van van mijn strucuur voor werken 
Online webapp
https://mohamedaminehssinoui-odisee.be/oef1/webapp/
/www/oef1/
   ├─ api/
   │   ├─ base.php
   │   ├─ dbcon.php
   │   ├─ .htaccess
   │   ├─ concerts.php            ← RESTful API (fichier unique)
   │   └─ inc/
   │        └─ concerts/          ← versie volgens de docent
   │            ├─ get.php
   │            ├─ add.php
   │            ├─ update.php
   │            └─ delete.php
   └─ webapp/
       ├─ index.html
       ├─ js/script.js
       └─ css/stijl.css



/////////////////////////////////////////////////////////////////////////
HIER in verband met opdracht 1 


Naam: RESTful API – Concert Tickets
Student: Mohamed Amine Hssinoui
Opleiding: Toegepaste Informatica – Odisee Hogeschool
Vak: Web & Mobile
Live Webapplicatie: https://www.mohamedaminehssinoui-odisee.be/oef1/webapp/


2. Technische Structuur
API Architectuur (/api/)
![alt text](image.png)

front end structuur 
![alt text](image-2.png)


Database Structuur
De MySQL-database (ID477568_Restfulapi)
 bevat drie kerntabellen die de many-to-many relatie tussen bezoekers en concerten mogelijk maken:
![ ](image-1.png)
concerts (id, artist, date, time, venue, price)

visitors (id, first_name, last_name, birth_date, email)

tickets (id, visitor_id, concert_id, qty)

3. API Endpoints & Postman Tests
Hieronder staan nieuwe, gevarieerde voorbeelden om de API met Postman te testen.

Concerts API
Endpoint: https://www.mohamedaminehssinoui-odisee.be/oef1/api/concerts.php
get , post , put , delete 

Visitors API
Endpoint: https://www.mohamedaminehssinoui-odisee.be/oef1/api/visitors.php
get , post , put , delete 

Tickets API
Endpoint: https://www.mohamedaminehssinoui-odisee.be/oef1/api/tickets.php


4. Werkplanning & Projectafwerking
Datum	Activiteit
Za 04/10	Opzetten van de database-structuur op Combell en configuratie van de connectie (dbcon.php).
Zo 05/10	Implementatie van de concerts.php router en succesvol testen van alle GET-requests via Postman.
Ma 06/10	Ontwikkeling van de POST-functionaliteit (add.php) voor alle endpoints.
Di 07/10	Implementatie en testen van de PUT-methodes (update.php) om gegevens te kunnen wijzigen.
Wo 08/10	Afronden van de API met DELETE-functionaliteit en het voltooien van de volledige CRUD-cyclus voor concerts, visitors en tickets. Alle endpoints werden succesvol gevalideerd met Postman.

Fase 2: Front-end Webapplicatie (5 dagen: 07/10 - 12/10)
Gedurende vijf dagen werd de webapplicatie ontwikkeld met HTML, CSS  JavaScript.

Structuur: De HTML-bestanden (index.html, visitors.html, tickets.html) 

Styling: Een eerste versie van de stijl.css werd geschreven om de lay-out en het design vorm te geven.

Logica: De kern van het werk lag in de JavaScript-bestanden. 
Hier werd de logica geschreven om via fetch (met async/await) te communiceren met de API,
 de JSON-data te verwerken en de pagina's dynamisch op te bouwen.

 Oké, perfect begrepen. Je wilt de "Werkplanning" in je README.md aanpassen zodat het de werkelijke tijdsindeling van je project beter reflecteert: 5 dagen voor de API, 5 dagen voor de front-end, en de laatste 3 dagen voor de afwerking.

Hier is de geüpdatete en meer gedetailleerde sectie voor je README.md. Dit vervangt de oude "Werkplanning" en de "Afronding" secties.

Je kunt dit direct kopiëren en in je oef1/README.md plakken.

4. Werkplanning en Projectontwikkeling
Het project werd in drie duidelijke fasen ontwikkeld over een periode van bijna twee weken, wat een realistische en grondige aanpak van het ontwikkelingsproces weerspiegelt.

Fase 1: Back-end API Ontwikkeling (5 dagen: 04/10 - 08/10)
De eerste vijf dagen waren volledig gewijd aan het bouwen en testen van de RESTful API. Het doel was om een solide en betrouwbare back-end te hebben voordat de ontwikkeling van de interface begon.

Datum	Activiteit
Za 04/10	Opzetten van de database-structuur op Combell en configuratie van de connectie (dbcon.php).
Zo 05/10	Implementatie van de concerts.php router en succesvol testen van alle GET-requests via Postman.
Ma 06/10	Ontwikkeling van de POST-functionaliteit (add.php) voor alle endpoints.
Di 07/10	Implementatie en testen van de PUT-methodes (update.php) om gegevens te kunnen wijzigen.
Wo 08/10	Afronden van de API met DELETE-functionaliteit en het voltooien van de volledige CRUD-cyclus voor concerts, visitors en tickets. Alle endpoints werden succesvol gevalideerd met Postman.

Exporter vers Sheets
Fase 2: Front-end Webapplicatie (5 dagen: 09/10 - 13/10)
Nadat de API was afgerond, verschoof de focus naar het bouwen van de gebruikersinterface. Gedurende vijf dagen werd de webapplicatie ontwikkeld met HTML, CSS en modern JavaScript.

Structuur: De HTML-bestanden (index.html, visitors.html, tickets.html) werden opgezet.

Styling: Een eerste versie van de stijl.css werd geschreven om de lay-out en het design vorm te geven.

Logica: De kern van het werk lag in de JavaScript-bestanden. Hier werd de logica geschreven om via fetch (met async/await) te communiceren met de API, de JSON-data te verwerken en de pagina's dynamisch op te bouwen.

Fase 3: Afwerking en Kwaliteitsverbetering (3 dagen: 09/10 - 12/10)
De laatste drie dagen waren cruciaal voor het afleveren  De focus lag op:

Code Refactoring: Zowel de PHP als de JavaScript-code werd grondig nagelezen en opgeschoond. 
Dubbele code werd verwijderd en de structuur werd geoptimaliseerd voor betere leesbaarheid.

Documentatie: De README.md werd gedetailleerd uitgewerkt 

Styling & UX: De CSS werd verder verfijnd voor een betere en consistentere gebruikerservaring op alle pagina's.

Finale Tests: van mijn api met postman om te zien als alles nog goed werk 

/////////////////////////////////////////////////////////////////////////


Oké, begrepen. Hier is een aangepaste versie van de tekst, zonder emoji's en met een meer natuurlijke, menselijke toon, alsof je zelf je weekverslag schrijft.

---

## Week 4 – Hybride Apps met Ionic & Vue.js
📅 **Datum:** 6 – 12 oktober 2025  
⏱️ **Tijd:** ± 10 uur  
🧠 **Wat gedaan:**

Deze week ben ik dieper ingegaan op hybride applicaties. De eerste stap was het volledig opzetten van de ontwikkelomgeving. Ik heb hiervoor Node.js, npm en de Ionic CLI geïnstalleerd.

Nadat de tools klaar stonden, heb ik een nieuw project aangemaakt met het Ionic Framework en Vue.js, vertrekkende vanuit de standaard 'tabs' template. Om te controleren of alles correct was geïnstalleerd, heb ik het project meteen getest met `ionic serve`, wat succesvol werkte in de browser.

Vervolgens heb ik het project, zoals in de les aangegeven, omgezet van TypeScript naar standaard JavaScript om de complexiteit wat te verlagen. Dit was een gedetailleerd proces waarbij ik configuratiebestanden (`package.json`, `.eslintrc.js`) moest aanpassen, bestanden moest hernoemen en de code in alle `.vue` componenten moest opschonen.

Daarna ben ik begonnen met de praktische oefening, waarbij ik de drie standaard tabs heb omgebouwd:
* **Tab 1:** Hier heb ik een formulier gebouwd voor het toevoegen van producten, gebruikmakend van de `ion-input` en `ion-radio-group` componenten voor de naam, prijs en categorie.
* **Tab 2:** Dit is nu een dynamische lijst van producten geworden. Ik heb er een `ion-searchbar` aan toegevoegd die de lijst in real-time filtert.
* **Tab 3:** Deze tab heb ik gebruikt om te experimenteren met verschillende andere Ionic componenten, zoals `ion-card`, `ion-avatar` en `ion-list`, om de mogelijkheden van het framework beter te leren kennen.





