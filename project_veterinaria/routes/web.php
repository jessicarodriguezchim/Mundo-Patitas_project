<?php //decir que es un archivo php
//es una importacion de la clase Route del framework Laravel- Route configuara las rutas de la aplicacion
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\PetController as ClientPetController;
use App\Http\Controllers\Client\ProfileController as ClientProfileController;

Route::redirect('/', '/admin');
//Route::get('/', function () {
  //  return view('welcome');
//});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Redirigir según el rol del usuario
        if ($user->hasRole('admin') || $user->hasRole('staff')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('client')) {
            return redirect()->route('client.pets.index');
        }
        
        return view('dashboard');
    })->name('dashboard');

    // Ruta de perfil - Cualquier usuario autenticado puede ver su propio perfil
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('/profile', [ClientProfileController::class, 'show'])->name('profile.show');
    });

    // Rutas para clientes - Solo pueden ver su propia información
    Route::middleware('role:client')->prefix('client')->name('client.')->group(function () {
        Route::resource('pets', ClientPetController::class)->only(['index', 'show'])->names('pets');
    });

    // Ruta para buscar usuarios (clientes) por nombre o email - Solo para admin/staff
    Route::middleware('role:admin,staff')->get('/api/users/search', function (Request $request) {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $users = \App\Models\User::role('client')
            ->where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('id_number', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email', 'id_number']);
        
        return response()->json($users);
    });
});

