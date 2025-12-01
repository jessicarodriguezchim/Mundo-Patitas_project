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
- ✅ Login con diseño cálido y acogedor (paleta naranjas, verdes y cremas)
- ✅ Imagen decorativa de perritos en la pantalla de login (responsive)
- ✅ Autenticación personalizada con verificación de usuario activo
- ✅ Sistema de cambio de contraseña desde el perfil
- ✅ Logout funcional
- ✅ Redirección automática a dashboard según rol
- ✅ Verificación de email
- ✅ Gestión de sesiones
- ✅ Fotos de perfil con soporte para imagen personalizada
- ✅ Placeholder automático con iniciales si no hay foto
- ✅ Tokens CSRF automáticos en todas las peticiones AJAX

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
- ✅ Eliminación física permanente de usuarios (solo administradores)
- ✅ Activación/Desactivación de usuarios (control de estado `is_active`)
- ✅ Verificación de usuario activo antes de permitir login
- ✅ Confirmaciones de eliminación con SweetAlert

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

### 6. Crear enlace simbólico de storage

```bash
php artisan storage:link
```

Este comando es necesario para que las fotos de perfil y otros archivos públicos sean accesibles desde el navegador.

### 7. Compilar assets

```bash
npm run build
# O para desarrollo con hot reload:
npm run dev
```

### 8. Iniciar el servidor

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

### Imágenes y Archivos

#### Imagen de Login

El sistema incluye soporte para una imagen decorativa de perritos en la pantalla de login. Para agregarla:

1. Coloca tu imagen en `public/images/` con uno de estos nombres:
   - `perritos.png`
   - `perritos.jpg`
   - `perritos.webp`
   - `dogs.png`
   - `dogs.jpg`
   - `perrogato02.png`

2. La imagen se mostrará automáticamente en el login con un diseño responsivo.

#### Fotos de Perfil

Las fotos de perfil se almacenan en `storage/app/public/profile-photos/` y son accesibles mediante el enlace simbólico creado con `php artisan storage:link`.

**Importante**: Asegúrate de ejecutar `php artisan storage:link` después de la instalación para que las fotos de perfil sean visibles.

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
│   │   ├── auth/                          # Vistas de autenticación
│   │   │   └── login.blade.php           # Login con diseño cálido
│   │   ├── client/                        # Vistas para clientes
│   │   ├── components/                    # Componentes Blade reutilizables
│   │   │   ├── authentication-card.blade.php  # Card de login con diseño
│   │   │   ├── wire-button.blade.php     # Botones con estilos cálidos
│   │   │   └── input.blade.php           # Inputs personalizados
│   │   └── layouts/
│   │       └── includes/
│   │           └── admin/
│   │               ├── sidebar.blade.php
│   │               └── navigation.blade.php
│   └── css/
│       └── app.css                        # Estilos con paleta cálida
├── public/
│   └── images/                            # Imágenes públicas
│       ├── logo.png                       # Logo de la aplicación
│       └── perritos.png                   # Imagen decorativa del login
├── storage/
│   └── app/
│       └── public/
│           └── profile-photos/            # Fotos de perfil de usuarios
├── routes/
│   ├── admin.php                          # Rutas del panel admin
│   ├── web.php                            # Rutas públicas y cliente
│   └── api.php
└── tailwind.config.js                     # Configuración Tailwind con colores cálidos
```

## 🔒 Roles y Permisos

### Admin
- ✅ Acceso completo al dashboard
- ✅ Gestión completa de usuarios (crear, editar, eliminar permanentemente)
- ✅ Control total: puede eliminar usuarios, mascotas y roles personalizados
- ✅ Gestión de roles (crear, editar, eliminar roles personalizados)
- ✅ Gestión completa de mascotas (crear, editar, eliminar)
- ✅ Los roles del sistema (admin, staff, client) están protegidos por seguridad
- ✅ No puede eliminarse a sí mismo como medida de seguridad

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

El sistema utiliza una paleta de colores cálidos y acogedores inspirada en aplicaciones de cuidado de mascotas (naranjas cálidos, verdes y cremas):

### Colores Principales

- **Naranja Cálido** (`pet-orange`): 
  - 50-200: Tonos claros para fondos y acentos suaves
  - 300-500: Colores principales para botones y elementos destacados (#F97316)
  - 600-900: Tonos oscuros para hover y elementos interactivos

- **Verde Turquesa** (`pet-green`):
  - 50-200: Fondos suaves y elementos secundarios
  - 300-500: Acentos verdes (#22C55E) para elementos complementarios
  - 600-900: Tonos profundos para estados activos

- **Crema** (`pet-cream`):
  - 50-100: Fondos principales (#FFFEF9, #FFF8F0)
  - 200-500: Variaciones para profundidad visual

### Aplicación en la Interfaz

- **Fondos**: Gradientes suaves de crema a naranja claro para una experiencia acogedora
- **Botones principales**: Naranjas cálidos con efectos hover y sombras suaves
- **Botones secundarios**: Verdes turquesa para acciones complementarias
- **Botones destructivos**: Naranjas intensos para acciones de eliminación
- **Bordes y acentos**: Naranjas y verdes en diferentes tonos con transparencias
- **Login**: Degradados suaves de naranja a verde con imagen decorativa de perritos responsive
- **Cards y contenedores**: Fondos cremas con bordes suaves y sombras naranjas

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
   - Gestionar usuarios en "Usuarios" (crear, editar, eliminar permanentemente)
   - Gestionar roles en "Roles y Permisos" (crear, editar, eliminar roles personalizados)
   - Gestionar mascotas en "Mascotas" (crear, editar, eliminar)
4. **Capacidades especiales**:
   - Eliminación física permanente de usuarios y mascotas
   - Confirmaciones con SweetAlert antes de eliminar
   - Control total del sistema (excepto eliminar roles del sistema por seguridad)

### Acceso como Staff

1. Inicia sesión con: `staff1@mundopatitas.com` / `password`
2. Accede al dashboard en `/admin`
3. Puedes gestionar mascotas (crear, editar, eliminar)
4. ❌ No puedes gestionar usuarios ni roles

### Acceso como Cliente

1. Inicia sesión con: `client1@mundopatitas.com` / `password`
2. Serás redirigido a `/client/pets`
3. Puedes ver tu perfil y tus mascotas
4. Puedes cambiar tu contraseña desde tu perfil (`/user/profile`)

### Cambiar Contraseña

**Como usuario autenticado:**
1. Ve a tu perfil: Haz clic en tu foto → "Profile" o visita `/user/profile`
2. Desplázate a la sección "Update Password"
3. Ingresa tu contraseña actual y la nueva
4. Guarda los cambios

**Como administrador para otros usuarios:**
1. Ve a "Usuarios" en el panel admin
2. Edita el usuario deseado
3. Ingresa la nueva contraseña (opcional)
4. Guarda los cambios

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel 12**: Framework PHP moderno
- **Laravel Jetstream**: Autenticación y scaffolding con fotos de perfil
- **Laravel Fortify**: Autenticación personalizada con verificación de usuario activo
- **Laravel Sanctum**: Autenticación API
- **Spatie Laravel Permission**: Gestión avanzada de roles y permisos

### Frontend
- **Livewire 3**: Componentes interactivos sin escribir JavaScript
- **Laravel Livewire Tables**: Tablas dinámicas con búsqueda y paginación
- **Tailwind CSS 3**: Framework CSS con paleta de colores personalizada
- **Flowbite**: Componentes UI interactivos
- **WireUI**: Componentes adicionales para Livewire
- **SweetAlert2**: Alertas y confirmaciones elegantes
- **Phosphor Icons**: Iconografía moderna
- **Font Awesome**: Iconos adicionales

### Herramientas
- **Vite**: Build tool moderno para assets
- **MySQL**: Base de datos relacional
- **Blade**: Motor de plantillas de Laravel
- **Axios**: Cliente HTTP para peticiones AJAX

## 📝 Buenas Prácticas Implementadas

- ✅ Rutas organizadas con `Route::resource`
- ✅ Controladores tipo Resource con código completamente comentado
- ✅ Middleware personalizado para protección de rutas
- ✅ Autenticación personalizada con verificación de usuario activo
- ✅ Migraciones para todas las tablas
- ✅ Seeders y Factories para datos de prueba
- ✅ Separación de vistas (admin/client)
- ✅ Componentes Blade reutilizables y limpios (sin comentarios visibles)
- ✅ Validación de datos en controladores
- ✅ Eliminación física (hard delete) para administradores con confirmaciones
- ✅ Control de estado de usuarios con `is_active`
- ✅ Diseño responsivo con Tailwind CSS
- ✅ Paleta de colores cálida y consistente en toda la aplicación
- ✅ Manejo de imágenes con storage simbólico
- ✅ Componentes UI accesibles y modernos
- ✅ Confirmaciones de eliminación con SweetAlert2
- ✅ Tokens CSRF automáticos en todas las peticiones AJAX
- ✅ Código PHP completamente comentado para facilitar el estudio
- ✅ Vistas Blade limpias y profesionales

## 🧪 Testing

Para ejecutar los tests:

```bash
php artisan test
```

## 📦 Comandos Útiles

```bash
# Limpiar todos los cachés
php artisan optimize:clear

# Limpiar caché de vistas
php artisan view:clear

# Limpiar caché de configuración
php artisan config:clear

# Limpiar caché de rutas
php artisan route:clear

# Recompilar assets
npm run build

# Desarrollo con hot reload
npm run dev

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders (crea roles, usuarios y mascotas de prueba)
php artisan db:seed

# Crear enlace simbólico de storage (IMPORTANTE para fotos de perfil)
php artisan storage:link

# Crear nuevo usuario desde tinker
php artisan tinker
>>> $user = App\Models\User::create(['name' => 'Nombre', 'email' => 'email@ejemplo.com', 'password' => Hash::make('contraseña'), 'id_number' => '123456789', 'phone' => '0000000000', 'address' => 'Dirección', 'is_active' => true]);
>>> $user->assignRole('admin');

# Activar/Desactivar usuario
php artisan tinker
>>> $user = App\Models\User::where('email', 'email@ejemplo.com')->first();
>>> $user->is_active = true; // o false
>>> $user->save();
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

## 🎨 Diseño e Interfaz

### Características de Diseño

- **Interfaz moderna y cálida**: Colores cálidos inspirados en aplicaciones de cuidado de mascotas (naranjas, verdes y cremas)
- **Login acogedor**: Diseño con degradados suaves y imagen decorativa de perritos responsive
- **Responsive**: Adaptado para dispositivos móviles, tablets y desktop
- **Componentes consistentes**: Botones, inputs y cards con estilo uniforme
- **Accesibilidad**: Contraste adecuado y elementos interactivos claros
- **Código limpio**: Vistas Blade sin comentarios visibles para una presentación profesional

### Imagen de Login

El login incluye soporte para mostrar una imagen decorativa de perritos que se adapta automáticamente al diseño:
- **Desktop**: Imagen a la izquierda, formulario a la derecha
- **Mobile**: Imagen arriba, formulario abajo
- **Efectos visuales**: Bordes redondeados, sombras suaves y efecto hover de escala
- **Placeholder automático**: Si no se encuentra la imagen, se muestra un placeholder

## 🔒 Seguridad y Características Avanzadas

### Autenticación Personalizada

- ✅ Verificación de usuario activo antes de permitir login
- ✅ Usuarios inactivos no pueden iniciar sesión (aunque las credenciales sean correctas)
- ✅ Mensajes de error personalizados para usuarios inactivos
- ✅ Sistema de cambio de contraseña seguro desde el perfil

### Gestión de Eliminaciones

- ✅ **Administradores** pueden eliminar permanentemente usuarios, mascotas y roles personalizados
- ✅ Confirmaciones con SweetAlert2 antes de eliminar
- ✅ Protección: Los roles del sistema (admin, staff, client) no se pueden eliminar
- ✅ Protección: Los administradores no pueden eliminarse a sí mismos
- ✅ Eliminación completa: Se eliminan fotos de perfil, tokens API y relaciones

### Tokens CSRF

- ✅ Tokens CSRF automáticos en todas las peticiones AJAX
- ✅ Configuración automática de Axios para incluir tokens CSRF
- ✅ Protección contra ataques Cross-Site Request Forgery

### Código y Documentación

- ✅ **Código PHP completamente comentado**: Todos los controladores, modelos, acciones, middlewares, seeders y factories tienen comentarios detallados para facilitar el estudio y comprensión
- ✅ **Vistas Blade limpias**: Sin comentarios visibles en las páginas (código limpio y profesional)
- ✅ **Documentación completa**: README actualizado con todas las funcionalidades y características

## 🙏 Agradecimientos

- Laravel Community
- Spatie por el paquete de permisos
- Tailwind CSS por el framework de utilidades
- Todos los contribuidores de los paquetes utilizados

---

⭐ Si este proyecto te fue útil, considera darle una estrella en GitHub!
