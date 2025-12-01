# 🔐 Guía para Cambiar Contraseña

## 📋 Opción 1: Cambiar tu propia contraseña (Como usuario autenticado)

### Paso a paso:

1. **Inicia sesión** en la aplicación con tus credenciales actuales:
   - Email: `admin@mundopatitas.com`
   - Contraseña: `password`

2. **Accede a tu perfil de usuario:**
   - Si eres **administrador o staff**: Haz clic en tu foto de perfil (esquina superior derecha) → Selecciona "Profile" o "Perfil"
   - O visita directamente: `http://localhost:8000/user/profile`
   - Si eres **cliente**: Ve a "Mi Perfil" en el menú

3. **En la página de perfil, busca la sección "Update Password"** (Actualizar Contraseña)

4. **Completa el formulario:**
   - **Contraseña actual**: Ingresa tu contraseña actual (`password`)
   - **Nueva contraseña**: Ingresa tu nueva contraseña (mínimo 8 caracteres)
   - **Confirmar contraseña**: Vuelve a ingresar la nueva contraseña

5. **Haz clic en "Save" (Guardar)**

6. **¡Listo!** Tu contraseña ha sido cambiada. La próxima vez que inicies sesión, usa tu nueva contraseña.

---

## 👥 Opción 2: Cambiar la contraseña de otro usuario (Solo Administradores)

### Paso a paso:

1. **Inicia sesión como administrador**

2. **Ve al panel de administración:**
   - Haz clic en "Usuarios" en el menú lateral
   - O visita: `http://localhost:8000/admin/users`

3. **Encuentra el usuario que quieres editar:**
   - Busca el usuario en la lista
   - Haz clic en el botón de editar (ícono de lápiz) ✏️

4. **En el formulario de edición:**
   - **Nueva Contraseña**: Ingresa la nueva contraseña (opcional)
   - **Confirmar Contraseña**: Confirma la nueva contraseña
   - Si dejas estos campos **vacíos**, la contraseña NO se cambiará

5. **Haz clic en "Actualizar Usuario"**

6. **¡Listo!** La contraseña del usuario ha sido actualizada.

---

## 🔄 Opción 3: Cambiar contraseña desde la línea de comandos (Para desarrolladores)

Si necesitas cambiar una contraseña rápidamente desde la terminal:

```bash
php artisan tinker
```

Luego ejecuta:

```php
$user = App\Models\User::where('email', 'admin@mundopatitas.com')->first();
$user->password = Hash::make('nueva_contraseña');
$user->save();
exit
```

---

## ⚠️ Notas importantes:

- **La nueva contraseña debe tener al menos 8 caracteres**
- **No compartas tu contraseña con nadie**
- **Usa contraseñas seguras** (combina letras, números y caracteres especiales)
- **Si olvidaste tu contraseña**, puedes usar la opción "Forgot your password?" (¿Olvidaste tu contraseña?) en la página de login

---

## 🎯 Resumen rápido:

| Quién | Cómo | Dónde |
|-------|------|-------|
| **Tu propia contraseña** | Perfil de usuario | `/user/profile` → Sección "Update Password" |
| **Contraseña de otro usuario** | Panel Admin | `/admin/users` → Editar usuario |
| **Desde terminal** | Tinker | `php artisan tinker` → Código PHP |

---

¿Necesitas ayuda? ¡Pregunta!


