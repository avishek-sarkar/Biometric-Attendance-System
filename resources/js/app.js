require('./bootstrap');

document.addEventListener('DOMContentLoaded', function() {
    const navIcon = document.getElementById("navIcon");
    const sidePanel = document.getElementById("sidePanel");

    if (!navIcon || !sidePanel) return;

    function toggleSidePanel(event) {
        event.stopPropagation();
        if (sidePanel.style.width === "0px" || sidePanel.style.width === "") {
            sidePanel.style.width = "250px";
            navIcon.classList.add("active");
            document.addEventListener("click", closeSidePanelOnClickOutside);
        } else {
            sidePanel.style.width = "0";
            navIcon.classList.remove("active");
            document.removeEventListener("click", closeSidePanelOnClickOutside);
        }
    }

    function closeSidePanelOnClickOutside(event) {
        if (!sidePanel.contains(event.target) && !navIcon.contains(event.target)) {
            sidePanel.style.width = "0";
            navIcon.classList.remove("active");
            document.removeEventListener("click", closeSidePanelOnClickOutside);
        }
    }

    navIcon.addEventListener("click", toggleSidePanel);

    function handleResize() {
        if (window.innerWidth <= 768) {
            navIcon.style.display = 'block';
            sidePanel.style.width = "0";
        } else {
            navIcon.style.display = 'none';
            sidePanel.style.width = "0";
        }
    }

    window.addEventListener("resize", handleResize);
    handleResize();
});