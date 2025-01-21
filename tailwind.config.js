import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    safelist: [
        ...[
            "slate",
            "gray",
            "zinc",
            "neutral",
            "stone",
            "red",
            "orange",
            "amber",
            "yellow",
            "lime",
            "green",
            "emerald",
            "teal",
            "cyan",
            "sky",
            "blue",
            "indigo",
            "violet",
            "purple",
            "fuchsia",
            "pink",
            "rose",
        ].flatMap((color) => [`bg-${color}-500`, `text-${color}-500`]),
        ...["white", "black"].flatMap((color) => [
            `bg-${color}`,
            `text-${color}`,
        ]),
        "bg-green-100",
        "bg-green-900",
        "text-green-800",
        "text-green-300",
        "bg-blue-100",
        "bg-blue-900",
        "text-blue-800",
        "text-blue-300",
        "bg-red-100",
        "bg-red-900",
        "text-red-800",
        "text-red-300",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [require("flowbite/plugin")],
};
