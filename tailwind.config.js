/** @type {import('tailwindcss').Config} */

export default {
  content: [
    "./public/assets/**/*",
    "./**/*.php"
    ],
  theme: {
    extend: {
      screens: {
        1000: "1000px",
        820: "820px",
        750: "750px",
        680: "680px",
        425: "425px",
      },
      fontFamily: {
        poppins: ["Noto Sans PhagsPa", "serif"],
      },
    },
  },
  plugins: [],
};
