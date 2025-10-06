(function(){
	"use strict";
	/*jslint browser: true*/
	/*jslint devel: true*/

	let baseApiAddress = "https://mohamedaminehssinoui-odisee.be/les2/api2/";

	let alertEl = document.getElementById("alert");
	let opties = {
		method: "POST", // *GET, POST, PUT, DELETE, etc.
		mode: "cors", // no-cors, *cors, same-origin
		cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
		credentials: "omit" // include, *same-origin, omit
		/* Opgelet : volgende headers niet toevoegen :
		    JSON triggert de pre-flight mode, waardoor de toegang op
		    deze manier niet meer zal lukken. Tenzij daar in de API expliciet
        rekening is met gehouden ...
		*/
		/*, headers: {
			"Content-Type": "application/json",
			"Accept": "application/json"
		}*/
	};

	function getApiGebruiker() {
		// een ONVEILIGE manier om gebruikersgegevens te testen
		let url = baseApiAddress + "login/";
		// dit endpoint verwacht dat je dit met POST aanspreekt
		opties.method = "POST"
		// onze php api verwacht een paar parameters

		// we voegen deze toe aan de body van de opties

		// body data type must match "Content-Type" header
		opties.body = JSON.stringify({
			name: document.getElementById("login").value,
			password: document.getElementById("pwd").value
		});

		// test de api
		fetch(url, opties)
			.then(function(response) {
				return response.json();
			})
			.then(function(responseData){
				// test status van de response
				if(responseData.status < 200 || responseData.status > 299) {
					// login faalde, boodschap weergeven
					// Hier kan je ook een groter onderscheid maken tussen de verschillende vormen van login falen.
					alerter("Login mislukt : deze naam/paswoord combinatie bestaat niet");
					// return, zodat de rest van de fetch niet verder uitgevoerd wordt
					return;
				}

				// de verwerking van de data
				var list = responseData.data;

				if (list.length > 0) {
					// list bevat minstens 1 itemproperty met waarde
					// we nemen het eerste
					alerter("Gebruikersgevens ok : ID = " + list[0].ID);
				} else {
					alerter("Login failed : this login/password combination does not exist");
				}

			})
			.catch(function(error) {
				// verwerk de fout
				alertEl.innerHTML = "fout : " + error;
			});
	}

	function getApiProducten() {
		// de producten van de server opvragen en weergeven dmv de alerter functie
		let url = baseApiAddress + "products/";

		// Deze request werkt via GET
		opties.method = "GET";
		// Een GET of HEAD method geef je geen body mee		
		opties.body = null;

		// test de api
		fetch(url, opties)
			.then(function(response) {
				return response.json();
			})
			.then(function(responseData){
				// de verwerking van de data
				var list = responseData.data;

				if (list.length > 0) {
					// er zit minstens 1 item in list, we geven dit ook onmiddelijk weer
					var tLijst = `<span class="rij kOdd"><span>ID</span><span>Omschrijving</span><span>Categorie</span><span>Prijs</span></span>`;
					for (var i = 0; i < list.length; i++) {
						tLijst += `<span class="rij"><span>${ list[i].PR_ID }</span><span>${ list[i].PR_naam }</span><span>${ list[i].CT_OM }</span><span>${ list[i].PR_prijs }</span></span>`;
					}
					tLijst += "<br>";

					alerter(tLijst);
				} else {
					alerter("Servertijd kon niet opgevraagd worden");
				}

			})
			.catch(function(error) {
				// verwerk de fout
				alertEl.innerHTML = "fout : " + error;
			});
	}

	function getApiTijd() {
		// de tijd van de server opvragen en weergeven dmv de alerter functie
		let url = baseApiAddress + "time/";

		// Deze request werkt via GET
		opties.method = "GET";
		// Een GET of HEAD method geef je geen body mee		
		opties.body = null;

		// test de api
		fetch(url, opties)
			.then(function(response) {
				return response.json();
			})
			.then(function(responseData){
				// de verwerking van de data
				const list = responseData.data;

				if (Object.keys(list).length > 0) {
					// er zit slechts 1 item in de lijst, we geven dit ook onmiddelijk weer
					alerter("Servertijd : " + list.servertime);
				} else {
					alerter("Servertijd kon niet opgevraagd worden");
				}

			})
			.catch(function(error) {
				// verwerk de fout
				alerter("<br>API Fout. Probeer later nog eens.<br>(" + error + ")");
			});
	}


	// EventListeners
	document.getElementById("btnTestLogin").addEventListener("click", function(){
		getApiGebruiker();
	});

	document.getElementById("btnGetTijd").addEventListener("click", function(){
		getApiTijd();
	});

	document.getElementById("btnGetProducten").addEventListener("click", function(){
		getApiProducten();
	});

	// helper functies
	function alerter(message) {
		alertEl.innerHTML = message;
	}
})();

