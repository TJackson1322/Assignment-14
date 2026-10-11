"use strict";

const form = document.querySelector("#contact-form");
const statusMessage = document.querySelector("#status");

form.addEventListener("submit", async (event) => {
    event.preventDefault();
    statusMessage.textContent = "";

    const email = document.querySelector("#email").value.trim();
    const message = document.querySelector("#message").value.trim();
    const csrfToken = document.querySelector("#csrf-token").value;

    try {
        const response = await fetch("contact.php", {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body: JSON.stringify({ email, message })
        });

        const result = await response.json();

        // textContent displays the response as text instead of parsing HTML.
        statusMessage.textContent = result.message || "Request completed.";

        if (response.ok) {
            form.reset();
        }
    } catch (error) {
        statusMessage.textContent = "The message could not be sent.";
    }
});
