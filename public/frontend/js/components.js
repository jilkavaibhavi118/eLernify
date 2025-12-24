document.addEventListener("DOMContentLoaded", function() {
    // Function to load HTML components
    function loadComponent(id, file) {
        const element = document.getElementById(id);
        if (element) {
            fetch(file)
                .then(response => {
                    if (response.ok) return response.text();
                    throw new Error('Failed to load ' + file);
                })
                .then(data => {
                    element.innerHTML = data;
                    
                    // Re-initialize AOS if it's the footer/header being loaded
                    if (window.AOS) {
                        AOS.init({
                            duration: 800,
                            once: true
                        });
                    }

                    // Active link highlighting
                    if (id === 'header-placeholder') {
                        highlightActiveLink();
                    }
                })
                .catch(error => console.error(error));
        }
    }

    function highlightActiveLink() {
        const currentPage = window.location.pathname.split("/").pop() || "index.html";
        const navLinks = document.querySelectorAll(".nav-link");
        navLinks.forEach(link => {
            if (link.getAttribute("href") === currentPage) {
                link.classList.add("active");
            }
        });
    }

    // Check if running via file:// protocol
    if (window.location.protocol === 'file:') {
        console.warn('Elearnify: Modular components (Header/Footer) cannot be loaded when opening the HTML file directly. Please use a local server like "Live Server" in VS Code.');
        // Optionally show a non-intrusive message
        const warning = document.createElement('div');
        warning.style.cssText = 'position: fixed; bottom: 10px; right: 10px; background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 5px; font-size: 12px; z-index: 10000; border: 1px solid #f87171;';
        warning.innerHTML = '<strong>Developer Note:</strong> Header & Footer require a <a href="https://marketplace.visualstudio.com/items?itemName=ritwickdey.LiveServer" target="_blank" style="color: #b91c1c; text-decoration: underline;">Local Server</a> to load.';
        document.body.appendChild(warning);
        return;
    }

    // Load components
    const isLessonPage = window.location.pathname.includes("course-lesson.html");
    const headerFile = "includes/header.html";
    
    loadComponent("header-placeholder", headerFile);
    loadComponent("footer-placeholder", "includes/footer.html");
});
