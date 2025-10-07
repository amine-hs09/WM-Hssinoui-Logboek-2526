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
