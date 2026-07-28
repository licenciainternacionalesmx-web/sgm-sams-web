(() => {
  const form = document.querySelector("#lead-form");
  if (!form) return;
  const status = document.querySelector("#form-status");
  const preset = new URLSearchParams(location.search).get("service");
  if (preset && form.elements.service) form.elements.service.value = preset;
  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    status.textContent = "Enviando de forma segura…";
    const button = form.querySelector('button[type="submit"]');
    button.disabled = true;
    try {
      const response = await fetch(form.action, {
        method: "POST",
        body: new FormData(form),
        headers: { "Accept": "application/json" }
      });
      const data = await response.json();
      if (!response.ok || !data.ok) throw new Error(data.message || "No fue posible registrar la solicitud.");
      status.textContent = `Solicitud recibida. Folio: ${data.folio}`;
      form.reset();
    } catch (error) {
      status.textContent = error.message || "No fue posible enviar. Escríbenos por WhatsApp.";
    } finally {
      button.disabled = false;
    }
  });
})();
