document.addEventListener("DOMContentLoaded", () => {
  const popup = document.getElementById("popup");
  const closeBtn = document.getElementById("close-popup");

 // If popup exists on the page
    if (popup) {
    // 🔹 Close popup when the close button is clicked
    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
        popup.style.display = "none";
        });
    }

    // 🔹 Optional: Close popup when clicking outside the box
    popup.addEventListener("click", (e) => {
        if (e.target === popup) {
        popup.style.display = "none";
        }
    });


    // 🔹 Change color based on message type
    const popupText = popup.querySelector("p").textContent.toLowerCase();
    const popupContent = popup.querySelector(".popup-content");

    if (popupText.includes("successful") || popupText.includes("welcome")) {
      popupContent.style.borderLeft = "6px solid #28a745"; // green
    } else if (popupText.includes("failed") || popupText.includes("incorrect") || popupText.includes("not found")) {
      popupContent.style.borderLeft = "6px solid #dc3545"; // red
    } else {
      popupContent.style.borderLeft = "6px solid #007bff"; // blue (default/info)
    }

    // 🔹 Smooth fade-in animation when it appears
    popup.style.opacity = "0";
    popup.style.transition = "opacity 0.3s ease-in-out";
    setTimeout(() => {
      popup.style.opacity = "1";
    }, 50);
  }
});
