const apiVisitors =
  "https://www.mohamedaminehssinoui-odisee.be/oef1/api/visitors.php";
const tbody = document.getElementById("visitorBody");

const visitorFormEl = document.getElementById("visitorForm");
let editVisitorId = null;
visitorFormEl?.addEventListener("submit", async (e) => {
  e.preventDefault();

  const body = {
    first_name: document.getElementById("fname").value,
    last_name: document.getElementById("lname").value,
    birth_date: document.getElementById("birth").value,
    email: document.getElementById("mail").value,
  };

  try {
    let res, json;
    if (editVisitorId) {
      body.id = editVisitorId;
      res = await fetch(apiVisitors, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body),
      });
      json = await res.json();
      if (typeof showToast === "function")
        showToast(json.message || "Bezoeker bijgewerkt", "success");
      else alert(json.message || "Bezoeker bijgewerkt");
      editVisitorId = null;
    } else {
      res = await fetch(apiVisitors, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body),
      });
      json = await res.json();
      if (typeof showToast === "function")
        showToast(
          json.message ? "✅ " + json.message : "Bezoeker toegevoegd",
          "success"
        );
      else alert("✅ " + (json.message || "Bezoeker toegevoegd"));
    }
    e.target.reset();
    loadVisitors();
  } catch (err) {
    console.error(err);
    if (typeof showToast === "function") showToast("Kon niet opslaan", "error");
  }
});

async function loadVisitors() {
  tbody.innerHTML = "<tr><td colspan='4'>⏳ Laden...</td></tr>";
  const res = await fetch(apiVisitors);
  const json = await res.json();
  tbody.innerHTML = "";

  json.data.forEach((v) => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${v.id}</td>
      <td>${v.first_name} ${v.last_name}</td>
      <td>${v.email || "-"}</td>
      <td>${v.birth_date || "-"}</td>
      <td>
        <button class="primary-outline" data-view="${v.id}">Bekijk</button>
        <button class="primary-outline" data-edit="${v.id}">Edit</button>
        <button class="primary-outline" data-delete="${v.id}">Delete</button>
      </td>
    `;
    tbody.appendChild(row);
  });

  // bind edit/delete handlers
  tbody.querySelectorAll("button[data-edit]").forEach((b) =>
    b.addEventListener("click", (e) => {
      const id = e.currentTarget.getAttribute("data-edit");
      const tr = e.currentTarget.closest("tr");
      if (!tr) return;
      const cols = tr.querySelectorAll("td");
      document.getElementById("fname").value =
        cols[1].textContent.split(" ")[0] || "";
      document.getElementById("lname").value =
        cols[1].textContent.split(" ").slice(1).join(" ") || "";
      document.getElementById("mail").value = cols[2].textContent || "";
      document.getElementById("birth").value = cols[3].textContent || "";
      editVisitorId = id;
      window.scrollTo({ top: 0, behavior: "smooth" });
    })
  );

  tbody.querySelectorAll("button[data-delete]").forEach((b) =>
    b.addEventListener("click", async (e) => {
      const id = e.currentTarget.getAttribute("data-delete");
      if (!confirm("Weet je zeker dat je deze bezoeker wilt verwijderen?"))
        return;
      try {
        const res = await fetch(apiVisitors, {
          method: "DELETE",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id: parseInt(id) }),
        });
        const json = await res.json();
        if (typeof showToast === "function")
          showToast(json.message || "Verwijderd", "success");
        else alert(json.message || "Verwijderd");
        loadVisitors();
      } catch (err) {
        console.error(err);
        if (typeof showToast === "function")
          showToast("Kon niet verwijderen", "error");
      }
    })
  );

  // view handlers
  tbody.querySelectorAll("button[data-view]").forEach((b) =>
    b.addEventListener("click", async (e) => {
      const id = e.currentTarget.getAttribute("data-view");
      try {
        const res = await fetch(apiVisitors + "?id=" + encodeURIComponent(id));
        const json = await res.json();
        const info =
          json.data && json.data.visitor ? json.data.visitor : json.data;
        const tickets = json.data && json.data.tickets ? json.data.tickets : [];
        const visitorModal = document.getElementById("visitorModal");
        const visitorInfo = document.getElementById("visitorInfo");
        const visitorConcerts = document.getElementById("visitorConcerts");
        if (visitorInfo)
          visitorInfo.textContent = info
            ? info.first_name +
              " " +
              info.last_name +
              (info.email ? " — " + info.email : "")
            : "Geen data";
        if (visitorConcerts)
          visitorConcerts.innerHTML =
            (tickets || [])
              .map(
                (t) =>
                  `<div class="card"><div class="body"><h4>${t.artist}</h4><p>${t.venue} — ${t.date}</p><p>Aantal: ${t.qty}</p></div></div>`
              )
              .join("") || '<p class="muted">Geen tickets</p>';
        if (visitorModal) visitorModal.setAttribute("aria-hidden", "false");
      } catch (err) {
        console.error(err);
        if (typeof showToast === "function")
          showToast("Kon bezoeker niet laden", "error");
      }
    })
  );

  // visitor modal close
  const visitorClose = document.getElementById("visitorClose");
  visitorClose?.addEventListener("click", () => {
    const m = document.getElementById("visitorModal");
    if (m) m.setAttribute("aria-hidden", "true");
  });
}

loadVisitors();
