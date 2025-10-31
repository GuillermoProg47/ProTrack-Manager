# ProTrack (Scaffold Laravel ligero)

Este directorio `laravel-app/` contiene un scaffold sencillo con estructura MVC y soporte multilenguaje (ES/EN) pensado para integrarse en un proyecto Laravel real.

Qué incluye
- `app/Http/Controllers/HomeController.php` — controlador de ejemplo.
- `app/Models/Task.php` — modelo Eloquent simple.
- `routes/web.php` — rutas: `/` y `lang/{lang}` para cambiar el idioma (sesión).
- `resources/views/layouts/app.blade.php` — layout con Bootstrap CDN.
- `resources/views/home.blade.php` — vista home con tarjetas visuales.
- `resources/lang/en/messages.php` y `resources/lang/es/messages.php` — traducciones.

Cómo usar (Windows PowerShell)
1. Crear un proyecto Laravel real (si no lo tienes):

   composer create-project laravel/laravel my-project

2. Copiar los archivos del scaffold al proyecto Laravel:

   # desde este folder, copia todo dentro de 'my-project'
   cp -Re "./laravel-app/*" "..\my-project\"  # en PowerShell, o usa Explorer

   # Alternativamente, mueve archivos manualmente: app/, resources/, routes/web.php, public/css/

3. Ajustes necesarios en Laravel real:
- En `app/Providers/AppServiceProvider.php` dentro de `boot()` añade para leer el idioma de la sesión:

```php
use Illuminate\Support\Facades\App;

public function boot()
{
    $locale = session('app_locale', config('app.locale'));
    App::setLocale($locale);
}
```

- Asegúrate de ejecutar migrations / composer / npm si añades paquetes:

   cd my-project; composer install; php artisan key:generate; php artisan serve

Pruebas rápidas
- Abrir `http://127.0.0.1:8000/` (después de `php artisan serve`).
- Cambia el idioma con `/lang/es` o `/lang/en`.

Limitaciones
- Este repo no instala automáticamente Laravel aquí. Debes crear el proyecto Laravel con Composer y copiar/mergear estos archivos.
- La ruta de cambio de idioma usa sesión y `App::setLocale` en `AppServiceProvider`; para producción considera middleware dedicado.

Si quieres, puedo:
- Integrar esto directamente en un nuevo `composer create-project` (si me permites ejecutar comandos aquí), o
- Añadir autenticación scaffolding y CRUD real para `Task` con migraciones y pruebas.

