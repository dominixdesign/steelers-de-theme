/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./templates/**/*.html5", "./src/**/*.js", "./src/**/*.vue"],
  theme: {
    extend: {
      colors: {
        steelwhite: "#eef0eb",
        steelnav: "#009a44",
        steelgreen: "#10b75a",
        steelblue: "#009cde",
        steellightgreen: "#10b75a",
      },
      aspectRatio: {
        news: "4 / 5",
      },
      spacing: {
        defaultbig: "150px",
      },
      keyframes: {
        wiggle: {
          "70%,100%": {
            transform: "rotate(0deg) scale(1)",
          },
          "80%": {
            transform: "rotate(-3deg) scale(1.1)",
          },
          "90%": {
            transform: "rotate(3deg) scale(0.9)",
          },
          "95%": {
            transform: "rotate(-3deg) scale(1)",
          },
        },
      },
      animation: {
        wiggle: "wiggle 5s ease-in-out infinite",
      },
      fontFamily: {
        sans: [
          "WhyteReg",
          "Lucida Sans Unicode",
          "Geneva",
          "Verdana",
          "sans-serif",
        ],
        headline: [
          "Whyte",
          "Lucida Sans Unicode",
          "Geneva",
          "Verdana",
          "sans-serif",
        ],
        headlineItalic: [
          "WhyteSuperItalic",
          "Lucida Sans Unicode",
          "Geneva",
          "Verdana",
          "sans-serif",
        ],
      },
    },
  },
  plugins: [
    require("postcss-import"),
    require("@tailwindcss/forms"),
    require("@tailwindcss/aspect-ratio"),
  ],
};
