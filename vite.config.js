import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  build: {
    outDir: "dist/js/",
    assetsDir: "./",
    rollupOptions: {
      output: {
        manualChunks: {},
        entryFileNames: "[name].js",
      },
    },
  },
});
