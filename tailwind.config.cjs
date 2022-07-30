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
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
