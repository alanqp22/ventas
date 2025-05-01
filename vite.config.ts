import { defineConfig } from "vite";
import path from "path";

export default defineConfig({
  root: "resources", // donde está tu TS
  build: {
    outDir: "../public/dist", // donde estará el JS generado
    emptyOutDir: true,
    rollupOptions: {
      input: {
        login: path.resolve("resources/ts/login.ts"),
        dashboard: path.resolve("resources/ts/dashboard.ts"),
        usuarios: path.resolve("resources/ts/usuarios.ts"),
      },
    },
  },
});
