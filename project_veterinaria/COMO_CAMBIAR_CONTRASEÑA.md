# 🔐 Cómo Cambiar tu Contraseña

## ✅ Opción 1: Cambiar tu propia contraseña (Desde tu Perfil)

### Pasos:

1. **Inicia sesión** con tus credenciales:
   - Email: `admin@mundopatitas.com`
   - Contraseña: `password`

2. **Accede a tu perfil de Jetstream:**
   - Haz clic en tu **foto de perfil** (esquina superior derecha)
   - Selecciona **"Profile"** o **"Perfil"**
   - O visita directamente: `http://localhost:8000/user/profile`

3. **En la página de perfil, desplázate hasta la sección "Update Password"** (Actualizar Contraseña)

4. **Completa el formulario:**
   - **Current Password** (Contraseña actual): `password`
   - **New Password** (Nueva contraseña): Ingresa tu nueva contraseña (mínimo 8 caracteres)
   - **Confirm Password** (Confirmar contraseña): Vuelve a ingresar la nueva contraseña

5. **Haz clic en "Save"** (Guardar)

6. **¡Listo!** La próxima vez que inicies sesión, usa tu nueva contraseña.

---

## 👥 Opción 2: Cambiar la contraseña de otro usuario (Solo Administradores)

### Pasos:

1. **Inicia sesión como administrador**

2. **Ve al panel de administración:**
   - En el menú lateral, haz clic en **"Usuarios"**
   - O visita: `http://localhost:8000/admin/users`

3. **Encuentra el usuario que quieres editar:**
   - Busca el usuario en la lista
   - Haz clic en el botón de **editar** (ícono de lápiz ✏️)

4. **En el formulario de edición:**
   - **Nueva Contraseña**: Ingresa la nueva contraseña (opcional - si dejas vacío, no se cambiará)
   - **Confirmar Contraseña**: Confirma la nueva contraseña
   - Puedes cambiar otros datos del usuario también (nombre, email, etc.)

5. **Haz clic en "Actualizar Usuario"**

6. **¡Listo!** La contraseña ha sido actualizada.

---

## 🔧 Opción 3: Cambiar contraseña desde la Terminal (Para desarrolladores)

Si necesitas cambiar una contraseña rápidamente desde la línea de comandos:

```bash
php artisan tinker
```

Luego ejecuta:

```php
$user = App\Models\User::where('email', 'admin@mundopatitas.com')->first();
$user->password = Hash::make('tu_nueva_contraseña');
$user->save();
exit
```

---

## 📝 Notas importantes:

- ✅ La nueva contraseña debe tener **mínimo 8 caracteres**
- ✅ Usa contraseñas seguras (combina letras, números y caracteres especiales)
- ✅ Si olvidaste tu contraseña, usa "Forgot your password?" en la página de login
- ✅ Los administradores pueden cambiar cualquier contraseña desde el panel

---

## 🎯 Resumen rápido:

| Acción | Dónde ir | URL |
|--------|----------|-----|
| **Cambiar mi contraseña** | Perfil → Update Password | `/user/profile` |
| **Cambiar contraseña de otro** | Admin → Usuarios → Editar | `/admin/users` |

¡Listo para cambiar tu contraseña! 🚀


