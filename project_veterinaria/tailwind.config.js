import defaultTheme from "tailwindcss/defaultTheme";

import forms from "@tailwindcss/forms";

import typography from "@tailwindcss/typography";

import flowbite from "flowbite/plugin";

import wireui from "./vendor/wireui/wireui/tailwind.config.js";




/** @type {import('tailwindcss').Config} */

export default {

    presets: [wireui],

    content: [

        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",

        "./vendor/laravel/jetstream/**/*.blade.php",

        "./storage/framework/views/*.php",

        "./resources/views/**/*.blade.php",



        "./vendor/wireui/wireui/src/*.php",

        "./vendor/wireui/wireui/ts/**/*.ts",

        "./vendor/wireui/wireui/src/WireUi/**/*.php",

        "./vendor/wireui/wireui/src/Components/**/*.php",



        "./vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php",



        "./node_modules/flowbite/**/*.js",

    ],

    theme: {

        extend: {

            fontFamily: {

                sans: ["Figtree", ...defaultTheme.fontFamily.sans],

            },

            colors: {

                // Colores principales pastel
                'pastel-aqua': '#AEE6E6',      // Aguamarina suave
                'pastel-pink': '#F7C8D0',     // Rosa pastel
                
                // Colores secundarios
                'pastel-peach': '#FFDCC2',    // Melocotón suave
                'pastel-yellow': '#FFF7AE',   // Amarillo pastel
                
                // Neutros
                'pastel-gray-light': '#F4F4F4', // Gris muy claro
                'pastel-gray-text': '#6F6F6F',  // Gris suave para texto
            },

            borderRadius: {

                'soft': '12px',      // Bordes redondeados suaves
                'soft-lg': '16px',   // Bordes redondeados grandes
            },

            boxShadow: {

                'soft': '0 2px 8px rgba(174, 230, 230, 0.15)',      // Sombra suave aguamarina
                'soft-pink': '0 2px 8px rgba(247, 200, 208, 0.15)', // Sombra suave rosa
                'soft-lg': '0 4px 16px rgba(174, 230, 230, 0.12)',  // Sombra suave grande
            },

        },

    },

    plugins: [forms, typography, flowbite],

};
