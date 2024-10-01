# Gestión de Eventos

**Versión:** 2.0  
**Autor:** Santiago Martínez  
**Descripción:** Un plugin para gestionar eventos en WordPress, que incluye un bloque Gutenberg y un robusto desarrollo backend.  

---

## Descripción del Plugin

El plugin **Gestión de Eventos** permite la creación y administración de eventos dentro de WordPress. Los usuarios pueden gestionar sus eventos, visualizar próximos eventos en el frontend a través de un bloque de Gutenberg y agregar galerías de imágenes a cada evento. El backend ha sido desarrollado para manejar eficientemente la gestión de eventos y la programación de tareas relacionadas.

---

## Funcionalidades Principales

- **Gestión de Eventos Personalizada:** Permite crear, modificar y eliminar eventos a través de un custom post type.
- **Bloque Gutenberg:** Un bloque que muestra los próximos 5 eventos, incluyendo:
  - Título del evento.
  - Imagen principal.
  - Descripción del evento.
  - Fecha (y hora si la hay).
  - Galería de imágenes por evento.
- **Galería de Imágenes:** Cada evento puede incluir una galería de imágenes que se muestra en el frontend.
- **Sistema Cron:** Un cron para la actualización automática de eventos.
- **Shortcode para Eventos:** Puedes insertar eventos en cualquier parte del sitio mediante un shortcode.
- **Seguridad:** Se han añadido medidas de seguridad para proteger los datos de los eventos.
- **Backend Robusto:** La lógica y funcionalidades backend están diseñadas para manejar un gran volumen de eventos de manera eficiente.

---

## Instalación

1. Sube el archivo del plugin al directorio `/wp-content/plugins/` o instálalo directamente a través de la página de plugins de WordPress.
2. Activa el plugin en el menú 'Plugins' de WordPress.
3. Crea eventos a través del custom post type "Eventos" en el administrador de WordPress.

---

## Uso del Bloque Gutenberg

- En el editor de WordPress, busca el bloque llamado **"Bloque de Eventos"**.
- Al agregar este bloque, se mostrará automáticamente el próximo evento con su título, foto principal, descripción, fecha y galería de imágenes (si está disponible).
- El frontend está diseñado con un estilo sencillo y claro, ya que el foco ha sido un desarrollo backend robusto y altamente eficiente.

---

## Desarrollo

El desarrollo del plugin se centró en construir un backend robusto para la gestión de eventos, asegurando que el sistema sea escalable y eficiente. 

**Tecnologías Utilizadas:**

- **PHP:** Para la lógica de backend y la creación de las APIs necesarias.
- **MySQL:** Para la base de datos y almacenamiento de los eventos.
- **JavaScript:** Para la integración con el editor de bloques Gutenberg.
- **CSS (con Bootstrap):** Para el diseño simple pero elegante del frontend.

---

## Changelog

**2.0:**
- Se añadió el soporte para bloques de Gutenberg.
- Implementación de galerías de imágenes por evento.
- Mejora en el cron y en la seguridad del plugin.
- Estilos con Bootstrap para el frontend del plugin.

---


