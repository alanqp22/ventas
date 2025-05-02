import { defineConfig } from "vite";
import path from "path";
import { fileURLToPath } from "url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

export default defineConfig({
  root: "resources",
  base: "/Assets/",
  build: {
    outDir: "../Assets",
    emptyOutDir: false,
    manifest: true,
    rollupOptions: {
      input: {
        //caja: path.resolve(__dirname, "resources/caja/caja.ts"),
        usuario: path.resolve(__dirname, "resources/usuario/app.ts"),
      },
    },
  },
});
