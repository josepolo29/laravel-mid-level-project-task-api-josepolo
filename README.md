# 📦 Laravel Project & Task API

API RESTful desarrollada con Laravel 12 para la **gestión de proyectos y tareas**, cumpliendo con buenas prácticas modernas: filtros dinámicos, validaciones estrictas, documentación con Swagger, auditoría y monitoreo con Telescope.

---

## ✅ Requisitos del sistema

- PHP >= 8.2  
- Composer  
- MySQL o MariaDB  
- Node.js y npm (opcional)  
- Laravel 12  
- Navegador moderno (para Swagger y Telescope)

---

## ⚙️ Instalación paso a paso

1. **Clonar el repositorio**  
```bash
git clone https://github.com/josepolo29/laravel-mid-level-project-task-api-josepolo.git
cd laravel-mid-level-project-task-api-josepolo
```

2. **Instalar dependencias**  
```bash
composer install
```

3. **Copiar el archivo de entorno y configurar**  
```bash
cp .env.example .env
```

Edita el `.env` y configura la base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_api
DB_USERNAME=root
DB_PASSWORD=
```

4. **Generar clave de aplicación**  
```bash
php artisan key:generate
```

5. **Ejecutar migraciones**  
```bash
php artisan migrate
```

6. **Levantar el servidor**  
```bash
php artisan serve
```

Accede a la API en: [http://localhost:8000](http://localhost:8000)

---

## 📘 Cómo levantar Swagger

1. Generar la documentación:  
```bash
php artisan l5-swagger:generate
```

2. Abrir en el navegador:  
[http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

---

## 🔭 Cómo ver Telescope

1. Instalar (ya incluido):  
```bash
php artisan telescope:install
php artisan migrate
```

2. Abrir en el navegador:  
[http://localhost:8000/telescope](http://localhost:8000/telescope)

Verás registros de:
- Requests
- SQL Queries
- Logs
- Excepciones
- Eventos y más

---

## 🔍 Cómo probar filtros dinámicos

### Proyectos – `GET /api/projects`

| Filtro       | Parámetro              | Ejemplo                                               |
|--------------|------------------------|--------------------------------------------------------|
| Estado       | `status`               | `/api/projects?status=active`                         |
| Nombre       | `name`                 | `/api/projects?name=Gestión`                          |
| Rango fechas | `from_date`, `to_date` | `/api/projects?from_date=2024-01-01&to_date=2024-12-31` |

### Tareas – `GET /api/tasks`

| Filtro        | Parámetro     | Ejemplo                                          |
|---------------|---------------|--------------------------------------------------|
| Estado        | `status`      | `/api/tasks?status=pending`                     |
| Prioridad     | `priority`    | `/api/tasks?priority=high`                      |
| Fecha límite  | `due_date`    | `/api/tasks?due_date=2025-06-01`                |
| Proyecto      | `project_id`  | `/api/tasks?project_id=uuid-del-proyecto`       |

---

## 🕵️ Cómo ver logs de auditoría

Gracias a [owen-it/laravel-auditing](https://github.com/owen-it/laravel-auditing):

1. Se auditan automáticamente creaciones, actualizaciones y eliminaciones de proyectos y tareas.

2. Ver directamente en base de datos:  
```sql
SELECT * FROM audits ORDER BY created_at DESC;
```

3. O en código:

```php
$project->audits;
$task->audits;
```

Opcional: puedes crear un endpoint tipo `/api/projects/{id}/audits`.

---

## 🚀 Autor

José Luis Polo Quispe  
[https://github.com/josepolo29](https://github.com/josepolo29)