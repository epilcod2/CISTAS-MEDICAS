# 🏥 Sistema Web de Citas Médicas Portable

<p align="center">
  <b>Sistema web ligero, autónomo y portable para la gestión de citas clínicas y pacientes.</b><br>
  Desarrollado como proyecto académico bajo metodologías ágiles (Sprints).
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-7.x%20%2F%208.x-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/SQLite-Embebido-003B57?style=for-the-badge&logo=sqlite&logoColor=white" alt="SQLite">
  <img src="https://img.shields.io/badge/HTML5%20%2F%20CSS3-Responsive-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5/CSS3">
  <img src="https://img.shields.io/badge/Plataforma-Portable-success?style=for-the-badge" alt="Portable">
</p>

---

## 📋 Descripción del Proyecto

El **Sistema Web de Citas Médicas Portable** es una solución web diseñada para operar de manera totalmente autónoma en entornos locales o unidades de almacenamiento extraíbles (memorias USB), eliminando la necesidad de instalar servidores complejos como WAMP o XAMPP, o requerir conexión permanente a internet. 

La aplicación gestiona la autenticación segura de usuarios, el registro de citas médicas por especialidades (Medicina General, Pediatría y Odontología) y la persistencia de datos en tiempo real mediante un motor de base de datos embebido.

---

## ✨ Características Principales

* **Portabilidad Absoluta (Serverless):** No requiere la configuración manual de servicios externos ni la importación de scripts SQL; la base de datos se genera y configura de forma automática en el primer arranque.
* **Seguridad y Buenas Prácticas:** Implementa consultas preparadas mediante **PDO (PHP Data Objects)** para prevenir inyecciones SQL y sanitización de salida (`htmlspecialchars`) contra ataques XSS.
* **Interfaz Institucional Adaptativa:** Diseño limpio basado en *CSS Grid* y *Flexbox*, optimizado para pantallas de escritorio y dispositivos móviles.
* **Control de Sesiones:** Sistema de autenticación restringida con cierre de sesión seguro.

---

## 🛠️ Tecnologías Utilizadas

* **Backend:** PHP (con soporte para PDO SQLite).
* **Base de Datos:** SQLite (`citas_medicas.db`).
* **Frontend:** HTML5, CSS3 (Diseño personalizado y responsivo).
* **Automatización:** Script por lotes (`.bat`) para el despliegue instantáneo del servidor local embebido.

---

## 📂 Estructura de Directorios

```text
Sistema_Medico_Portable/
├── php/                    # Binarios portables del motor PHP y archivo de configuración
├── css/
│   └── style.css           # Hoja de estilos institucional y diseño visual
├── index.php               # Núcleo de la interfaz, control de sesiones y lógica de citas
├── db_config.php           # Script de conexión PDO y creación automática de SQLite
├── citas_medicas.db        # Archivo físico de base de datos SQLite (autogenerado)
└── EJECUTAR_SISTEMA.bat    # Lanzador automatizado del servidor local