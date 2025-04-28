<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('modules.users.index')->with('users', $users);
    }

    public function create()
    {
        return view('modules.users.usuarios_create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $password = $request->input('password');
        $input['password'] = bcrypt($password);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Usar el sistema de almacenamiento de Laravel
            $file_name = uniqid() . '.' . $image->getClientOriginalExtension();
            // Guardar la imagen en el disco 'public'
            $path = $image->storeAs('images/uploads', $file_name, 'public');

            // Optimizar la imagen recién subida
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize(storage_path('app/public/' . $path));

            $input['image'] = $file_name;
        } else {
            $input['image'] = 'default_user_image.png';
        }

        User::create($input)->assignRole($request->input('type'));
        return redirect()->route("usuarios.index")->with("success", "Usuario creado exitosamente.");
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Manejar la imagen del usuario si se proporciona
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Generar un nombre de archivo único
            $file_name = uniqid() . '.' . $image->getClientOriginalExtension();
            // Guardar la nueva imagen
            $path = $image->storeAs('images/uploads', $file_name, 'public');

            // Eliminar la imagen anterior si existe y no es la imagen por defecto
            if ($user->image != 'default_user_image.png') {
                $oldImagePath = storage_path('app/public/images/uploads/' . $user->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // Optimizar la imagen recién subida
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize(storage_path('app/public/' . $path));

            // Asignar el nuevo nombre de archivo a la propiedad del usuario
            $user->image = $file_name;
        }

        // Validar la contraseña si se proporciona
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user->password = Hash::make($request->input('password'));
        }

        // Guardar los cambios en el usuario
        $user->save();

        // Actualizar roles del usuario
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('type'));

        return redirect()->route("usuarios.index")->with("success", "Usuario actualizado exitosamente.");
    }
    
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route("usuarios.index")->with("success", "El usuario fue eliminado de manera exitosa.");
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1451) {
                $message = 'Lo siento, no se puede eliminar este usuario porque tiene registros asociados en la tabla de ventas. Si desea eliminar este usuario, primero debe eliminar todos los registros asociados en la tabla de ventas.';
                return view('modules.users.usuarios_delete', compact('message'));
            } else {
                return redirect()->route('usuarios.index')->with('error', 'Error al eliminar el usuario.');
            }
        }
    }
}
