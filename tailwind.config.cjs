/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./templates/**/*.html5", "./src/**/*.js"],
  theme: {
    extend: {},
  },
  plugins: [require("@tailwindcss/forms")],
};
