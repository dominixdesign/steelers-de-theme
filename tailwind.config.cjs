/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./templates/**/*.html5", "./src/**/*.js", "./src/**/*.vue"],
  theme: {
    extend: {
      colors: {
        steelwhite: "#eef0eb",
        steelnav: "#10b75a",
        steelgreen: "#10b75a",
        steelblue: "#009cde",
        steellightgreen: "#10b75a",
      },
      typography: {
        DEFAULT: {
          css: {
            "--tw-prose-body": "#000",
            lineHeight: "auto",
            "--tw-prose-bullets": "#000",
            ul: {
              paddingLeft: "1.25em",
            },
            a: {
              color: "var(--tw-prose-body)",
              "&:hover": {
                color: "#10b75a",
              },
            },
            "a.email": {
              color: "var(--tw-prose-body)",
              "&:hover": {
                color: "#10b75a",
              },
            },
          },
        },
      },
      aspectRatio: {
        news: "4 / 5",
      },
      spacing: {
        defaultbig: "150px",
      },
      width: {
        p60: "60px",
        p40: "40px",
      },
      height: {
        p60: "60px",
        p40: "40px",
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
          "PP Formula",
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
          "WhyteItalic",
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
    require("@tailwindcss/typography"),
    require("@tailwindcss/forms")({
      strategy: "base", // only generate global styles
    }),
    require("@tailwindcss/aspect-ratio"),
    require("autoprefixer"),
  ],
};
