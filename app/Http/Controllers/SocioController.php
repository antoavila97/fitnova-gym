<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSocioRequest;
use App\Http\Requests\UpdateSocioRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SocioController extends Controller
{
    public function index(Request $request)
    {
        $termino = $request->query('q');

        $socios = User::where('role', 'socio')
            ->when($termino, function ($query, $termino) {
                $query->where(fn ($q) => $q
                    ->where('name', 'like', "%{$termino}%")
                    ->orWhere('email', 'like', "%{$termino}%")
                    ->orWhere('documento', 'like', "%{$termino}%"));
            })
            ->with('membresiaActiva.plan')
            ->orderBy('name')
            ->paginate(10);

        if ($request->wantsJson()) {
            return response()->json($socios);
        }

        return view('socios.index', compact('socios', 'termino'));
    }

    public function buscarJson(Request $request)
    {
        $termino = $request->query('q', '');
        $socios = User::where('role', 'socio')
            ->when($termino, function ($query, $termino) {
                $query->where(fn ($q) => $q
                    ->where('name', 'like', "%{$termino}%")
                    ->orWhere('email', 'like', "%{$termino}%")
                    ->orWhere('documento', 'like', "%{$termino}%"));
            })
            ->with('membresiaActiva.plan')
            ->orderBy('name')
            ->limit(20)
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'email' => $s->email,
                'documento' => $s->documento,
                'telefono' => $s->telefono,
                'plan_activo' => $s->membresiaActiva?->plan?->nombre,
            ]);

        return response()->json($socios);
    }

    public function create()
    {
        return view('socios.create');
    }

    public function store(StoreSocioRequest $request)
    {
        User::create(array_merge($request->validated(), ['role' => 'socio']));

        return redirect()->route('socios.index')->with('success', 'Socio dado de alta correctamente.');
    }

    public function show(User $socio)
    {
        $socio->load([
            'membresias.plan',
            'pagos',
            'rutinasAsignadas.entrenador',
        ]);

        return view('socios.show', compact('socio'));
    }

    public function edit(User $socio)
    {
        abort_unless($socio->esSocio(), 404);

        return view('socios.edit', compact('socio'));
    }

    public function update(UpdateSocioRequest $request, User $socio)
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $socio->update($data);

        return redirect()->route('socios.show', $socio)->with('success', 'Socio actualizado correctamente.');
    }

    public function destroy(User $socio)
    {
        $socio->delete();

        return redirect()->route('socios.index')->with('success', 'Socio eliminado.');
    }
}
