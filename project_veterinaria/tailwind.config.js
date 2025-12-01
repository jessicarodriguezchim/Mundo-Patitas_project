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
                // Colores principales cálidos (inspirados en la app de mascotas)
                'pet-orange': {
                    50: '#FFF8F0',   // Crema muy claro
                    100: '#FFE8D6',  // Crema claro
                    200: '#FFD4A3',  // Melocotón muy claro
                    300: '#FFB870',  // Melocotón claro
                    400: '#FF9C4D',  // Naranja claro
                    500: '#FF7A2E',  // Naranja principal
                    600: '#FF6B1A',  // Naranja intenso
                    700: '#E55A0F',  // Naranja oscuro
                    800: '#CC4D0D',  // Naranja más oscuro
                    900: '#B33F0A',  // Naranja muy oscuro
                },
                'pet-green': {
                    50: '#F0FDFC',   // Verde muy claro
                    100: '#CCFBF1',  // Verde claro
                    200: '#99F6E4',  // Verde suave
                    300: '#5EEAD4',  // Verde turquesa claro
                    400: '#2DD4BF',  // Verde turquesa
                    500: '#14B8A6',  // Verde principal
                    600: '#0D9488',  // Verde intenso
                    700: '#0F766E',  // Verde oscuro
                    800: '#115E59',  // Verde más oscuro
                    900: '#134E4A',  // Verde muy oscuro
                },
                'pet-cream': {
                    50: '#FFFEF9',   // Blanco crema
                    100: '#FFF8F0',  // Crema muy claro
                    200: '#FFF2E1',  // Crema claro
                    300: '#FFE8D6',  // Crema suave
                    400: '#F5E6D3',  // Crema medio
                    500: '#E8DCC8',  // Crema principal
                },
                
                // Alias para compatibilidad
                'pastel-aqua': '#5EEAD4',      // Verde turquesa claro
                'pastel-pink': '#FF9C4D',     // Naranja claro
                'pastel-peach': '#FFB870',    // Melocotón
                'pastel-yellow': '#FFD4A3',   // Amarillo crema
                'pastel-gray-light': '#FFFEF9', // Crema muy claro
                'pastel-gray-text': '#6B7280',  // Gris suave para texto
            },

            borderRadius: {

                'soft': '12px',      // Bordes redondeados suaves
                'soft-lg': '16px',   // Bordes redondeados grandes
            },

            boxShadow: {

                'soft': '0 2px 8px rgba(255, 122, 46, 0.15)',      // Sombra suave naranja
                'soft-green': '0 2px 8px rgba(20, 184, 166, 0.15)', // Sombra suave verde
                'soft-pink': '0 2px 8px rgba(255, 156, 77, 0.15)', // Sombra suave naranja claro
                'soft-lg': '0 4px 16px rgba(255, 122, 46, 0.12)',  // Sombra suave grande
            },

        },

    },

    plugins: [forms, typography, flowbite],

};
