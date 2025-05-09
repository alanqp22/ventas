// CSS Modules (si usas .module.css)
declare module "*.module.css";
declare module "*.module.scss";

// Archivos CSS/SCSS globales
declare module "*.css";
declare module "*.scss";

// Imágenes
declare module "*.png" {
  const value: string;
  export default value;
}

declare module "*.jpg" {
  const value: string;
  export default value;
}

declare module "*.jpeg" {
  const value: string;
  export default value;
}

declare module "*.svg" {
  const content: string;
  export default content;
}
