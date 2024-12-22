function toggleMenu() {
  const toggleButton = document.getElementById("menu-toggle");
  const hamburgerIcon = document.getElementById("hamburger-icon");
  const closeIcon = document.getElementById("close-icon");
  const sideMenu = document.getElementById("side-menu");

  sideMenu.classList.toggle("-translate-x-full");

  const isExpanded = toggleButton.getAttribute("aria-expanded") === "true";
  toggleButton.setAttribute("aria-expanded", !isExpanded);

  if (isExpanded) {
    hamburgerIcon.classList.remove("hidden");
    closeIcon.classList.add("hidden");
    toggleButton.classList.remove("bg-red-600");
    toggleButton.classList.add("bg-gray-800");
  } else {
    hamburgerIcon.classList.add("hidden");
    closeIcon.classList.remove("hidden");
    toggleButton.classList.remove("bg-gray-800");
    toggleButton.classList.add("bg-red-600");
  }
}

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("hamburger-icon").classList.remove("hidden");
});

function setActiveTab(page) {
  const sidebarLinks = document.querySelectorAll("nav a");
  sidebarLinks.forEach((link) => {
    link.classList.remove("bg-purple-700", "text-white");
    if (link.getAttribute("href") === page) {
      link.classList.add("bg-purple-700", "text-white");
    }
  });
}

const currentPage = window.location.pathname;
setActiveTab(currentPage);
