/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./templates/**/*.html5", "./src/**/*.js", "./src/**/*.vue"],
  theme: {
    extend: {
      colors: {
        steelwhite: "#f5faf8",
        steelgreen: "#069848",
        steelblue: "#009cde",
        steellightgreen: "#29fb86",
      },
      fontFamily: {
        headline: [
          "Whyte",
          "Lucida Sans Unicode",
          "Geneva",
          "Verdana",
          "sans-serif",
        ],
        headlineItalic: [
          "WhyteItalic",
          "Lucida Sans Unicode",
          "Geneva",
          "Verdana",
          "sans-serif",
        ],
      },
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
