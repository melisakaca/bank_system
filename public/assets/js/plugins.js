// Check if any of the elements exist in the DOM
if (
    document.querySelector("[toast-list]") ||
    document.querySelector("[data-choices]") ||
    document.querySelector("[data-provider]")
) {
    // Function to dynamically load a script
    function loadScript(src) {
        const script = document.createElement("script");
        script.src = src;
        script.type = "text/javascript";
        document.body.appendChild(script);
    }

    // Load the necessary scripts
    loadScript("https://cdn.jsdelivr.net/npm/toastify-js");
    loadScript("{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}");
    loadScript("{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}");
}
