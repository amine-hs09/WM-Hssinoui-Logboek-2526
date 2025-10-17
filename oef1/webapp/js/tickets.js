// tickets.js hier zijn de ticket functies verbonden met api 
const apiTickets = "https://www.mohamedaminehssinoui-odisee.be/oef1/api/tickets.php";
const apiConcerts = "https://www.mohamedaminehssinoui-odisee.be/oef1/api/concerts.php";
const apiVisitors = "https://www.mohamedaminehssinoui-odisee.be/oef1/api/visitors.php";

const ticketList = document.getElementById("ticketList");
const visitorSelect = document.getElementById("visitorSelect");
const concertSelect = document.getElementById("concertSelect");
const ticketFormEl = document.getElementById("ticketForm");

// hier zijn de element voor volgende modals 
const ticketDetailModal = document.getElementById("ticketDetailModal");
const ticketEditModal = document.getElementById("ticketEditModal");
let currentEditingTicketId = null;

// dezefuncite fetch met vis en con
async function fillSelects() {
  try {
    const [visitors, concerts] = await Promise.all([
      fetch(apiVisitors).then((r) => r.json()),
      fetch(apiConcerts).then((r) => r.json()),
    ]);

    // if visitorSelect dan select ingevuld met een visitor 
    if (visitorSelect)
      visitorSelect.innerHTML = (visitors.data || [])
        .map((v) => `<option value="${v.id}">${v.first_name} ${v.last_name} (${v.email})</option>`)
        .join("");
    // if concert select dan ingevuld met concert 
    if (concertSelect)
      concertSelect.innerHTML = (concerts.data || [])
        .map((c) => `<option value="${c.id}">${c.artist} – ${c.venue} (€${parseFloat(c.price).toFixed(2)})</option>`)
        .join("");
  } catch (err) {
    // links op scherm beneden zie je een toast berich 
    if (typeof showToast === "function")
      showToast("⚠️ Kan de lijsten niet laden.");
    else alert("⚠️ Kan de lijsten niet laden.");
  }
}

// form van ticket bestaat uit visitorSelect concertSelect en qty
ticketFormEl?.addEventListener("submit", async (e) => {
  e.preventDefault();

  const body = {
    visitor_id: parseInt(visitorSelect.value),
    concert_id: parseInt(concertSelect.value),
    qty: parseInt(document.getElementById("qty").value),
  };
  
  try {
    // post request naar de api van ticket 
    const res = await fetch(apiTickets, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(body),
    });
    // json form waarmee je een toast bericht krijgt ticket aangemaakt 
    const json = await res.json();
    if (typeof showToast === "function")
      showToast(
        json.message ? "🎟️ " + json.message : "Ticket aangemaakt",
        "success"
      );
    else alert("🎟️ " + (json.message || "Ticket aangemaakt"));
    loadTickets();
  } catch (err) {
    showToast("Kon ticket niet aanmaken.", "error");
  }
});

// tickets laden en weergeven
async function loadTickets() {
  ticketList.innerHTML = "<p>⏳ Tickets laden...</p>";
  try {
    const [ticketsRes, concertsRes, visitorsRes] = await Promise.all([
      fetch(apiTickets), fetch(apiConcerts), fetch(apiVisitors),
    ]);
    // we halen ook de concerten en bezoekers op, zodat we die kunnen mappen
    const ticketsJson = await ticketsRes.json();
    const concertsJson = await concertsRes.json();
    const visitorsJson = await visitorsRes.json();

    const concertMap = (concertsJson.data || []).reduce((map, c) => ({ ...map, [c.id]: c }), {});
    // maak een map van bezoekers
    const visitorMap = (visitorsJson.data || []).reduce((map, v) => ({ ...map, [v.id]: v }), {});

    ticketList.innerHTML = "";

    (ticketsJson.data || []).forEach((t) => {
      const visitor = visitorMap[t.visitor_id] || { first_name: t.first_name, last_name: t.last_name };
      const concert = concertMap[t.concert_id] || { artist: t.artist, venue: t.venue };
      
      const card = document.createElement("div");
      card.className = "card";
      card.dataset.ticketId = t.id;
      // de id word gestokeerd gemakelijker 
      const thumb = document.createElement("div");
      thumb.className = "thumb";
      thumb.textContent = "🎟️";

      const body = document.createElement("div");
      body.className = "body";
      
      body.innerHTML = `
        <h3>Ticket #${t.id}</h3>
        <p>👤 ${visitor.first_name} ${visitor.last_name}</p>
        <p>🎵 ${concert.artist} - ${concert.venue}</p>
        <p>🎫 Aantal: ${t.qty}</p>
      `;

      // container voor de knopeen 
      const actions = document.createElement("div");
      actions.className = "card-actions";
      actions.innerHTML = `
        <button class="primary-outline btn-view">Bekijk</button>
        <button class="btn-edit">Edit</button>
        <button class="btn-delete">Verwijder</button>
      `;

      card.appendChild(thumb);
      card.appendChild(body);
      card.appendChild(actions);
      ticketList.appendChild(card);
    });
  } catch (err) {
    ticketList.innerHTML = '<p class="error">Kon tickets niet laden.</p>';
  }
}

// button event voor ticjets
ticketList.addEventListener('click', async (e) => {
  const target = e.target;
  const card = target.closest('.card');
  if (!card) return;

  const ticketId = card.dataset.ticketId;

  // vewijderen van een ticket 
  if (target.matches('.btn-delete')) {
    if (confirm(`Weet je zeker dat je ticket #${ticketId}  verwijderen?`)) {
      try {
        await fetch(apiTickets, {
          method: 'DELETE',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: parseInt(ticketId) })
        });
        showToast("Ticket verwijderd", "success");
        loadTickets();
      } catch (err) {
        showToast("Kon ticket niet verwijderen", "error");
      }
    }
  }

  // Lokika om de detil te bekijken 
  if (target.matches('.btn-view')) {
      const content = card.querySelector('.body').innerHTML;
      document.getElementById('ticketDetailTitle').textContent = `Details voor Ticket #${ticketId}`;
      document.getElementById('ticketDetailContent').innerHTML = content;
      ticketDetailModal.setAttribute('aria-hidden', 'false');
  }

  // logika voor de edit knop 
  if (target.matches('.btn-edit')) {
      currentEditingTicketId = ticketId;
      const info = card.querySelector('h3').textContent + " - " + card.querySelector('p').textContent;
      document.getElementById('ticketEditInfo').textContent = info;
      const currentQty = card.querySelector('p:nth-of-type(3)').textContent.replace('Aantal: ', '');
      document.getElementById('ticketEditQty').value = currentQty;
      ticketEditModal.setAttribute('aria-hidden', 'false');
  }
});

// sluit modals indien de close is getrukt
document.getElementById('ticketDetailClose')?.addEventListener('click', () => ticketDetailModal.setAttribute('aria-hidden', 'true'));
document.getElementById('ticketEditClose')?.addEventListener('click', () => ticketEditModal.setAttribute('aria-hidden', 'true'));

//  hier worden edit geslaagd van de ticket 
document.getElementById('ticketEditSave')?.addEventListener('click', async () => {
    const newQty = parseInt(document.getElementById('ticketEditQty').value);
    if (!currentEditingTicketId || !newQty || newQty < 1) {
        showToast("Ongeldig aantal", "error");
        return;
    }

    try {
        await fetch(apiTickets, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: parseInt(currentEditingTicketId), qty: newQty })
        });
        showToast("Ticket bijgewerkt", "success");
        ticketEditModal.setAttribute('aria-hidden', 'true');
        loadTickets();
    } catch (err) {
        showToast("Kon ticket niet bijwerken", "error");
    }
});



fillSelects();
loadTickets();