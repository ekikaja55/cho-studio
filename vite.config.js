import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/artist/commisions.js",
                "resources/js/artist/commissions_detail.js",
                "resources/js/artist/adoptions.js",
                "resources/js/artist/adoption_detail.js",
                "resources/js/member/history.js",
                "resources/js/member/history_commission_detail.js",
            ],
            refresh: true,
        }),
    ],
});
