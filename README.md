# 🏦 Sistema de Gestión de Clientes – Banco

WEB desplegada en alwaysdata: https://goncoder.alwaysdata.net/banco-mejorado/index.php

Este proyecto es una **aplicación web en PHP** que permite gestionar una base de datos de clientes de un banco.  
Incluye un formulario para **añadir clientes**, ordenarlos y administrar sus datos con funcionalidades básicas de seguridad.

---

## 📋 Funcionalidades

- **Añadir clientes** mediante un formulario sencillo.
- **Ordenar clientes** de mayor a menor (por ejemplo, por nombre o tlf).
- **Gestionar clientes** con botones para:
  - ✏️ **Modificar datos**.
  - 🗑️ **Eliminar registros**.
- **Validaciones y seguridad básica**:
  - No se pueden registrar **DNI duplicados**.
  - Control de tipos de datos en HTML (no se pueden ingresar datos erróneos).
  - Validación básica del formulario en el lado del cliente.

---

## 🖥️ Tecnologías Utilizadas

- **PHP** para la lógica del servidor.
- **MySQL** como base de datos.
- **HTML5** y **CSS3** para la interfaz.
- **Validaciones básicas** en HTML.

---

## 🖼️ Previsualizaciones

Vista previa de la aplicación (capturas en la carpeta `img` del proyecto):

![Captura 1](./img/Captura%20de%20pantalla%202025-09-19%201.png)
![Captura 2](./img/Captura%20de%20pantalla%202025-09-19%202.png)
![Captura 3](./img/Captura%20de%20pantalla%202025-09-19%203.png)
![Captura 4](./img/Captura%20de%20pantalla%202025-09-19%204.png)
![Captura 5](./img/Captura%20de%20pantalla%202025-09-19%205.png)


---

## 🗂️ Estructura del Repositorio

```plaintext
/
├── README.md
├── index.php                # Página principal
├── config.php                   # Conexión y funciones de base de datos
├── style.css
├── /img                     # Carpeta de capturas de pantalla
│   ├── Captura de pantalla 2025-09-19 1.png
│   ├── Captura de pantalla 2025-09-19 2.png
│   ├── ...
└── ...
