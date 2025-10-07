(function(){
  "use strict";
  /*jslint browser:true, devel:true*/

  var baseApiAddress = "https://mohamedaminehssinoui-odisee.be/oef1/api/";
  var alertBox = function(msg){ alert(msg); };

  // Un seul objet d’options, réutilisé et adapté à chaque appel
  var opties = {
    method: "GET",
    mode: "cors",
    cache: "no-cache",
    credentials: "omit"
    // PAS de headers "Content-Type: application/json" → évite preflight
  };

  // --- HELPERS ---
  function handleJson(r){ return r.json(); }
  function checkOk(payload){
    if (!payload || payload.code !== 1) { throw new Error(payload && payload.data ? payload.data : "API error"); }
    return payload.data;
  }

  // --- LOGIN (exemple façon prof) ---
  function testLogin(){
    var url = baseApiAddress + "login/";
    opties.method = "POST";
    opties.body = JSON.stringify({
      name: document.getElementById("login") ? document.getElementById("login").value : "test",
      password: document.getElementById("pwd") ? document.getElementById("pwd").value : "test"
    });

    fetch(url, opties)
      .then(handleJson)
      .then(function(res){
        if(res.status < 200 || res.status > 299){ alertBox("Login failed"); return; }
        var list = res.data;
        alertBox(list.length ? ("Gebruikersgegevens ok : ID=" + list[0].ID) : "Login failed");
      })
      .catch(function(e){ alertBox("Fout login: " + e.message); });
  }

  // --- CONCERTS ---
  function loadConcerts(){
    var url = baseApiAddress + "concerts/";
    opties.method = "GET";
    opties.body = null;

    fetch(url, opties)
      .then(handleJson).then(checkOk)
      .then(function(list){
        var el = document.getElementById("concertList");
        if(!el) return;
        el.innerHTML = "";
        list.forEach(function(c){
          var li = document.createElement("li");
          li.innerHTML =
            '<span><strong>'+c.artist+
            '</strong> — '+c.date+' '+c.time+' • <span class="muted">'+c.venue+
            '</span> • '+Number(c.price).toFixed(2)+'€</span>'+
            '<span>'+
            '<button class="secondary small" data-view="'+c.id+'">🔍</button>'+
            '<button class="small" data-edit="'+c.id+'">✏️</button>'+
            '<button class="danger small" data-del="'+c.id+'">🗑️</button>'+
            '</span>';
          el.appendChild(li);
        });
      })
      .catch(function(e){ alertBox("Fout concerts: " + e.message); });
  }

  function saveConcert(){
    var id = (document.getElementById("concertId")||{}).value || "";
    var payload = {
      artist: (document.getElementById("artist")||{}).value || "",
      date: (document.getElementById("date")||{}).value || "",
      time: (document.getElementById("time")||{}).value || "",
      venue: (document.getElementById("venue")||{}).value || "",
      price: parseFloat((document.getElementById("price")||{}).value || "0")
    };

    var url = baseApiAddress + "concerts/" + (id ? ("?id="+id) : "");
    opties.method = id ? "PUT" : "POST";
    opties.body = JSON.stringify(payload);

    fetch(url, opties)
      .then(handleJson).then(checkOk)
      .then(function(){ (document.getElementById("concertForm")||{}).reset && document.getElementById("concertForm").reset(); (document.getElementById("concertId")||{}).value=""; loadConcerts(); })
      .catch(function(e){ alertBox("Fout save concert: " + e.message); });
  }

  function deleteConcert(id){
    var url = baseApiAddress + "concerts/?id=" + id;
    opties.method = "DELETE";
    opties.body = null;

    fetch(url, opties)
      .then(handleJson).then(checkOk)
      .then(function(){ loadConcerts(); alertBox("Concert supprimé"); })
      .catch(function(e){ alertBox("Fout delete concert: " + e.message); });
  }

  function showConcertDetail(id){
    var urlC = baseApiAddress + "concerts/?id=" + id;
    opties.method = "GET"; opties.body = null;

    fetch(urlC, opties).then(handleJson).then(checkOk)
      .then(function(arr){
        var c = arr[0];
        var title = document.getElementById("cTitle");
        if(title){ title.textContent = "#"+c.id+" — "+c.artist+" @ "+c.venue+" ("+c.date+" "+c.time+")"; }
        var urlT = baseApiAddress + "tickets/?concert_id=" + id;
        return fetch(urlT, opties).then(handleJson).then(checkOk);
      })
      .then(function(tickets){
        var list = document.getElementById("concertVisitors");
        var box = document.getElementById("concertDetail");
        if(!list) return;
        list.innerHTML = "";
        tickets.forEach(function(t){
          var li = document.createElement("li");
          li.innerHTML = "<span>"+t.first_name+" "+t.last_name+" — "+t.email+"</span><span class='muted small'>x"+t.qty+"</span>";
          list.appendChild(li);
        });
        box && box.classList.remove("hidden");
      })
      .catch(function(e){ alertBox("Fout detail concert: " + e.message); });
  }

  // --- VISITORS ---
  function loadVisitors(){
    var url = baseApiAddress + "visitors/";
    opties.method = "GET"; opties.body = null;

    fetch(url, opties).then(handleJson).then(checkOk)
      .then(function(list){
        var el = document.getElementById("visitorList");
        if(!el) return;
        el.innerHTML = "";
        list.forEach(function(v){
          var li = document.createElement("li");
          li.innerHTML =
            '<span><strong>'+v.first_name+' '+v.last_name+
            '</strong> • <span class="muted">'+v.email+
            '</span></span><span>'+
            '<button class="secondary small" data-viewv="'+v.id+'">🔍</button>'+
            '<button class="small" data-editv="'+v.id+'">✏️</button>'+
            '<button class="danger small" data-delv="'+v.id+'">🗑️</button>'+
            '</span>';
          el.appendChild(li);
        });
      })
      .catch(function(e){ alertBox("Fout visitors: " + e.message); });
  }

  function saveVisitor(){
    var id = (document.getElementById("visitorId")||{}).value || "";
    var payload = {
      first_name: (document.getElementById("first_name")||{}).value || "",
      last_name: (document.getElementById("last_name")||{}).value || "",
      birth_date: (document.getElementById("birth_date")||{}).value || "",
      email: (document.getElementById("email")||{}).value || ""
    };
    var url = baseApiAddress + "visitors/" + (id ? ("?id="+id) : "");
    opties.method = id ? "PUT" : "POST";
    opties.body = JSON.stringify(payload);

    fetch(url, opties).then(handleJson).then(checkOk)
      .then(function(){ (document.getElementById("visitorForm")||{}).reset && document.getElementById("visitorForm").reset(); (document.getElementById("visitorId")||{}).value=""; loadVisitors(); })
      .catch(function(e){ alertBox("Fout save visitor: " + e.message); });
  }

  function deleteVisitor(id){
    var url = baseApiAddress + "visitors/?id=" + id;
    opties.method = "DELETE"; opties.body = null;

    fetch(url, opties).then(handleJson).then(checkOk)
      .then(function(){ loadVisitors(); alertBox("Visiteur supprimé"); })
      .catch(function(e){ alertBox("Fout delete visitor: " + e.message); });
  }

  function showVisitorDetail(id){
    var urlV = baseApiAddress + "visitors/?id=" + id;
    opties.method = "GET"; opties.body = null;

    fetch(urlV, opties).then(handleJson).then(checkOk)
      .then(function(arr){
        var v = arr[0];
        var title = document.getElementById("vTitle");
        if(title){ title.textContent = "#"+v.id+" — "+v.first_name+" "+v.last_name+" ("+v.email+")"; }
        // tickets
        var urlT = baseApiAddress + "tickets/?visitor_id=" + id;
        return fetch(urlT, opties).then(handleJson).then(checkOk);
      })
      .then(function(tickets){
        var list = document.getElementById("visitorTickets");
        var box = document.getElementById("visitorDetail");
        if(list){
          list.innerHTML = "";
          tickets.forEach(function(t){
            var li = document.createElement("li");
            li.innerHTML = "<span>"+t.artist+" — "+t.date+" "+t.time+" @ "+t.venue+"</span><span class='muted small'>x"+t.qty+"</span>";
            list.appendChild(li);
          });
        }
        // charger concerts pour l’achat
        var urlC = baseApiAddress + "concerts/";
        return fetch(urlC, opties).then(handleJson).then(checkOk);
      })
      .then(function(concerts){
        var sel = document.getElementById("buyConcert");
        if(sel){
          sel.innerHTML = "";
          concerts.forEach(function(c){
            var o = document.createElement("option");
            o.value = c.id; o.textContent = "#"+c.id+" "+c.artist+" @ "+c.venue+" ("+c.date+")";
            sel.appendChild(o);
          });
        }
        var btn = document.getElementById("buyBtn");
        if(btn){
          btn.onclick = function(){
            var payload = {
              visitor_id: parseInt(id,10),
              concert_id: parseInt((document.getElementById("buyConcert")||{}).value || "0",10),
              qty: Math.max(1, parseInt((document.getElementById("buyQty")||{}).value || "1",10))
            };
            var url = baseApiAddress + "tickets/";
            opties.method = "POST";
            opties.body = JSON.stringify(payload);
            fetch(url, opties).then(handleJson).then(checkOk)
              .then(function(){ showVisitorDetail(id); alertBox("Ticket acheté !"); })
              .catch(function(e){ alertBox("Fout buy ticket: " + e.message); });
          };
        }
        (document.getElementById("visitorDetail")||{}).classList && document.getElementById("visitorDetail").classList.remove("hidden");
      })
      .catch(function(e){ alertBox("Fout detail visitor: " + e.message); });
  }

  // --- EVENTS (se branchent sur l’HTML fourni) ---
  var el;

  el = document.getElementById("reloadConcerts");
  el && el.addEventListener("click", loadConcerts);

  el = document.getElementById("concertForm");
  el && el.addEventListener("submit", function(ev){ ev.preventDefault(); saveConcert(); });

  el = document.getElementById("concertReset");
  el && el.addEventListener("click", function(){ el.form && el.form.reset(); (document.getElementById("concertId")||{}).value=""; });

  el = document.getElementById("concertList");
  el && el.addEventListener("click", function(e){
    var id = e.target.dataset.edit || e.target.dataset.del || e.target.dataset.view;
    if(!id) return;
    if (e.target.dataset.edit){
      // charger dans le formulaire
      opties.method = "GET"; opties.body = null;
      fetch(baseApiAddress+"concerts/?id="+id, opties).then(handleJson).then(checkOk)
        .then(function(arr){
          var c = arr[0];
          (document.getElementById("concertId")||{}).value = c.id;
          (document.getElementById("artist")||{}).value = c.artist;
          (document.getElementById("date")||{}).value = c.date;
          (document.getElementById("time")||{}).value = c.time;
          (document.getElementById("venue")||{}).value = c.venue;
          (document.getElementById("price")||{}).value = c.price;
          window.scrollTo({top:0,behavior:"smooth"});
        });
    } else if (e.target.dataset.del){
      if(confirm("Supprimer ce concert ?")) deleteConcert(id);
    } else if (e.target.dataset.view){
      showConcertDetail(id);
    }
  });

  el = document.getElementById("reloadVisitors");
  el && el.addEventListener("click", loadVisitors);

  el = document.getElementById("visitorForm");
  el && el.addEventListener("submit", function(ev){ ev.preventDefault(); saveVisitor(); });

  el = document.getElementById("visitorReset");
  el && el.addEventListener("click", function(){ el.form && el.form.reset(); (document.getElementById("visitorId")||{}).value=""; });

  el = document.getElementById("visitorList");
  el && el.addEventListener("click", function(e){
    var id = e.target.dataset.editv || e.target.dataset.delv || e.target.dataset.viewv;
    if(!id) return;
    if (e.target.dataset.editv){
      opties.method = "GET"; opties.body = null;
      fetch(baseApiAddress+"visitors/?id="+id, opties).then(handleJson).then(checkOk)
        .then(function(arr){
          var v = arr[0];
          (document.getElementById("visitorId")||{}).value = v.id;
          (document.getElementById("first_name")||{}).value = v.first_name;
          (document.getElementById("last_name")||{}).value = v.last_name;
          (document.getElementById("birth_date")||{}).value = v.birth_date;
          (document.getElementById("email")||{}).value = v.email;
          window.scrollTo({top:document.body.scrollHeight, behavior:"smooth"});
        });
    } else if (e.target.dataset.delv){
      if(confirm("Supprimer ce visiteur ?")) deleteVisitor(id);
    } else if (e.target.dataset.viewv){
      showVisitorDetail(id);
    }
  });

  // Optionnel : bouton test login si présent
  el = document.getElementById("btnTestLogin");
  el && el.addEventListener("click", testLogin);

  // INIT
  loadConcerts();
  loadVisitors();
})();
