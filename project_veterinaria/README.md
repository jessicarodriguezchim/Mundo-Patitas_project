# 🐾 Mundo Patitas - Sistema de Gestión Veterinaria

Sistema de gestión completo para clínicas veterinarias desarrollado con Laravel 12, que incluye autenticación, gestión de roles, usuarios y módulo de mascotas (Pets) con CRUD completo.

## 📋 Tabla de Contenidos

- [Características](#-características)
- [Requisitos del Sistema](#-requisitos-del-sistema)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Roles y Permisos](#-roles-y-permisos)
- [Uso del Sistema](#-uso-del-sistema)
- [Tecnologías Utilizadas](#-tecnologías-utilizadas)
- [Estructura de Base de Datos](#-estructura-de-base-de-datos)
- [Contribuir](#-contribuir)
- [Licencia](#-licencia)

## ✨ Características

### 🔐 Autenticación
- ✅ Registro y login de usuarios con Laravel Jetstream
- ✅ Logout funcional
- ✅ Redirección automática a dashboard según rol
- ✅ Verificación de email
- ✅ Gestión de sesiones

### 👥 Gestión de Roles
- ✅ Sistema de roles con Spatie Permission
- ✅ Tres roles principales:
  - **Admin**: Acceso completo al sistema
  - **Staff**: Gestión de módulos del dominio (mascotas)
  - **Client**: Acceso limitado a su propia información
- ✅ Protección de rutas mediante middleware personalizado
- ✅ Asignación de roles desde panel administrativo

### 👤 Gestión de Usuarios
- ✅ Listado paginado de usuarios
- ✅ Creación de nuevos usuarios con asignación de rol
- ✅ Edición de datos básicos (nombre, email, rol, estado)
- ✅ Desactivación de usuarios (soft delete)
- ✅ Filtrado por rol y estado

### 🐕 Módulo de Mascotas (CRUD Completo)
- ✅ Listado de mascotas con paginación
- ✅ Creación de nuevas mascotas
- ✅ Edición de información de mascotas
- ✅ Visualización detallada
- ✅ Eliminación de mascotas
- ✅ Asociación con dueño (cliente)
- ✅ Restricción por rol (solo admin/staff pueden gestionar)

## 🖥️ Requisitos del Sistema

- PHP >= 8.2
- Composer
- Node.js >= 18.x y npm
- MySQL >= 8.0 o PostgreSQL
- Git

## 📦 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/mundo-patitas.git
cd mundo-patitas
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Configurar el archivo de entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edita el archivo `.env` con tus credenciales de base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mundo_patitas
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5. Ejecutar migraciones y seeders

```bash
php artisan migrate
php artisan db:seed
```

### 6. Compilar assets

```bash
npm run build
# O para desarrollo con hot reload:
npm run dev
```

### 7. Iniciar el servidor

```bash
php artisan serve
```

El sistema estará disponible en: `http://localhost:8000`

## ⚙️ Configuración

### Usuarios de Prueba

Después de ejecutar los seeders, puedes iniciar sesión con:

| Rol | Email | Contraseña |
|-----|-------|------------|
| Admin | admin@mundopatitas.com | password |
| Staff | staff1@mundopatitas.com | password |
| Client | client1@mundopatitas.com | password |

### Configuración de Roles

Los roles se crean automáticamente al ejecutar `php artisan db:seed`. Los roles disponibles son:

- `admin`: Administrador del sistema
- `staff`: Personal de la clínica
- `client`: Cliente/Dueño de mascotas

## 📁 Estructura del Proyecto

```
project_veterinaria/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── PetController.php      # CRUD de mascotas
│   │   │   │   ├── RoleController.php     # Gestión de roles
│   │   │   │   └── UserController.php     # Gestión de usuarios
│   │   │   └── Client/
│   │   │       ├── PetController.php      # Vista de mascotas para clientes
│   │   │       └── ProfileController.php  # Perfil de cliente
│   │   └── Middleware/
│   │       └── EnsureUserHasRole.php     # Middleware de roles
│   ├── Livewire/
│   │   └── Admin/
│   │       └── DataTables/                # Componentes Livewire Tables
│   ├── Models/
│   │   ├── Pet.php                        # Modelo de Mascotas
│   │   ├── Role.php
│   │   └── User.php
│   └── View/
│       └── Components/
├── database/
│   ├── factories/
│   │   ├── PetFactory.php                 # Factory para mascotas
│   │   └── UserFactory.php                # Factory para usuarios
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_pets_table.php
│   │   └── create_permission_tables.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RoleSeeder.php                 # Crea los roles
│       └── UserSeeder.php                 # Crea usuarios de prueba
├── resources/
│   ├── views/
│   │   ├── admin/                         # Vistas del panel admin
│   │   │   ├── pets/                      # CRUD de mascotas
│   │   │   ├── users/                     # CRUD de usuarios
│   │   │   └── roles/                     # CRUD de roles
│   │   ├── client/                        # Vistas para clientes
│   │   └── layouts/
│   │       └── includes/
│   │           └── admin/
│   │               ├── sidebar.blade.php
│   │               └── navigation.blade.php
│   └── css/
│       └── app.css                        # Estilos con paleta pastel
├── routes/
│   ├── admin.php                          # Rutas del panel admin
│   ├── web.php                            # Rutas públicas y cliente
│   └── api.php
└── tailwind.config.js                     # Configuración Tailwind con colores pastel
```

## 🔒 Roles y Permisos

### Admin
- ✅ Acceso completo al dashboard
- ✅ Gestión de usuarios (crear, editar, desactivar)
- ✅ Gestión de roles
- ✅ Gestión completa de mascotas

### Staff
- ✅ Acceso al dashboard
- ✅ Gestión de mascotas (crear, editar, eliminar)
- ❌ No puede gestionar usuarios ni roles

### Client
- ✅ Ver su propio perfil
- ✅ Ver sus propias mascotas
- ❌ No puede acceder al panel administrativo
- ❌ No puede gestionar otras mascotas

## 🎨 Paleta de Colores

El sistema utiliza una paleta de colores pastel tierna y bonita:

- **Aguamarina suave** (#AEE6E6): Botones principales
- **Rosa pastel** (#F7C8D0): Botones secundarios
- **Melocotón suave** (#FFDCC2): Acentos
- **Amarillo pastel** (#FFF7AE): Detalles
- **Gris muy claro** (#F4F4F4): Fondos
- **Gris suave** (#6F6F6F): Textos

## 🗄️ Estructura de Base de Datos

### Tabla: users
- `id`: Identificador único
- `name`: Nombre del usuario
- `email`: Email único
- `password`: Contraseña encriptada
- `id_number`: Número de identificación
- `phone`: Teléfono
- `address`: Dirección
- `is_active`: Estado activo/inactivo
- `email_verified_at`: Fecha de verificación
- `timestamps`: created_at, updated_at

### Tabla: pets
- `id`: Identificador único
- `name`: Nombre de la mascota
- `species`: Especie (Perro, Gato, etc.)
- `breed`: Raza (opcional)
- `age`: Edad (opcional)
- `owner_id`: ID del dueño (FK a users)
- `notes`: Notas adicionales
- `timestamps`: created_at, updated_at

### Tabla: roles (Spatie Permission)
- `id`: Identificador único
- `name`: Nombre del rol
- `guard_name`: Guard (web)
- `timestamps`: created_at, updated_at

## 🚀 Uso del Sistema

### Acceso como Administrador

1. Inicia sesión con: `admin@mundopatitas.com` / `password`
2. Accede al dashboard en `/admin`
3. Desde el sidebar puedes:
   - Gestionar usuarios en "Usuarios"
   - Gestionar roles en "Roles y Permisos"
   - Gestionar mascotas en "Mascotas"

### Acceso como Staff

1. Inicia sesión con: `staff1@mundopatitas.com` / `password`
2. Accede al dashboard en `/admin`
3. Puedes gestionar mascotas pero no usuarios ni roles

### Acceso como Cliente

1. Inicia sesión con: `client1@mundopatitas.com` / `password`
2. Serás redirigido a `/client/pets`
3. Puedes ver tu perfil y tus mascotas

## 🛠️ Tecnologías Utilizadas

- **Laravel 12**: Framework PHP
- **Laravel Jetstream**: Autenticación y scaffolding
- **Laravel Sanctum**: Autenticación API
- **Spatie Laravel Permission**: Gestión de roles y permisos
- **Livewire 3**: Componentes interactivos
- **Laravel Livewire Tables**: Tablas dinámicas
- **Tailwind CSS 3**: Framework CSS
- **Flowbite**: Componentes UI
- **WireUI**: Componentes adicionales
- **Vite**: Build tool
- **MySQL**: Base de datos

## 📝 Buenas Prácticas Implementadas

- ✅ Rutas organizadas con `Route::resource`
- ✅ Controladores tipo Resource
- ✅ Middleware personalizado para protección de rutas
- ✅ Migraciones para todas las tablas
- ✅ Seeders y Factories para datos de prueba
- ✅ Separación de vistas (admin/client)
- ✅ Componentes Blade reutilizables
- ✅ Validación de datos en controladores
- ✅ Soft deletes para usuarios (desactivación)

## 🧪 Testing

Para ejecutar los tests:

```bash
php artisan test
```

## 📦 Comandos Útiles

```bash
# Limpiar caché
php artisan optimize:clear

# Recompilar assets
npm run build

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders
php artisan db:seed

# Crear nuevo usuario desde tinker
php artisan tinker
>>> User::factory()->create()->assignRole('client');
```

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

### Convenciones de Commits

- `feat`: Nueva funcionalidad
- `fix`: Corrección de bug
- `docs`: Documentación
- `style`: Formato, estilos
- `refactor`: Refactorización
- `test`: Tests
- `chore`: Mantenimiento

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 👨‍💻 Autor

**Jessica Rodriguez**

- Email: jessica.rodriguez@tecdesoftware.com
- GitHub: [@tu-usuario](https://github.com/tu-usuario)

## 🙏 Agradecimientos

- Laravel Community
- Spatie por el paquete de permisos
- Todos los contribuidores de los paquetes utilizados

---

⭐ Si este proyecto te fue útil, considera darle una estrella en GitHub!
