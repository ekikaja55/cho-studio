import "./bootstrap"; // import bootstrap js

// import jquery
import $ from "jquery";
window.$ = window.jQuery = $; // Make sure jQuery is available globally

// import sweetalert2
import Swal from "sweetalert2";
window.Swal = Swal; // Make SweetAlert2 available globally

// import notie
import notie from "notie";
import "notie/dist/notie.min.css"; // import notie styles
window.notie = notie; // Make notie available globally

// import vue-toastification
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css"; // import the styles
window.Toast = Toast; // Make Toast available globally

// read token from meta and expose globally
const tokenMeta = document.querySelector('meta[name="csrf-token"]');
if (tokenMeta) {
    window.csrfToken = tokenMeta.getAttribute("content");

    // jQuery AJAX setup
    if (window.jQuery) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": window.csrfToken,
            },
        });
    }

    // axios (if you use it)
    if (window.axios) {
        window.axios.defaults.headers.common["X-CSRF-TOKEN"] = window.csrfToken;
    }
}

// Format number to Rupiah format (e.g., 1.000.000)
function formatRupiah(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Parse Rupiah format to number
function parseRupiah(rupiahString) {
    return parseInt(rupiahString.replace(/\./g, "")) || 0;
}

// Make Rupiah functions available globally
window.formatRupiah = formatRupiah;
window.parseRupiah = parseRupiah;