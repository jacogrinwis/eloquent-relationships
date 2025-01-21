import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    // server: {
    //     host: true,
    //     hmr: {
    //         host: "eloquent-relationships.test",
    //     },
    // },
    // server: {
    //     host: "eloquent-relationships.test",
    //     https: {
    //         key: readFileSync(
    //             `${process.env.HOME}/.config/herd/ssl/eloquent-relationships.test.key`
    //         ),
    //         cert: readFileSync(
    //             `${process.env.HOME}/.config/herd/ssl/eloquent-relationships.test.cert`
    //         ),
    //     },
    //     hmr: {
    //         host: "eloquent-relationships.test",
    //         protocol: "wss",
    //     },
    // },
});
