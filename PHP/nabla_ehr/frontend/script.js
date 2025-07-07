// ehr_app/frontend/script.js
const API_BASE = "../backend/";

function register() {
  const name = document.getElementById("reg-name").value;
  const role = document.getElementById("reg-role").value;

  fetch(API_BASE + "register.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ name, role }),
  })
    .then(res => res.json())
    .then(data => {
      alert("Registered successfully!");
      document.getElementById("reg-name").value = "";
    });
}

function fetchPatients() {
  fetch(API_BASE + "get_patients.php")
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById("patient-list");
      container.innerHTML = "";

      data.forEach(patient => {
        const div = document.createElement("div");
        div.innerHTML = `
          ${patient.name}
          <button onclick="viewEncounters(${patient.patient_id})">View Encounters</button>
        `;
        container.appendChild(div);
      });
    });
}

function viewEncounters(patientId) {
  window.location.href = `encounters.html?patient_id=${patientId}`;
}
