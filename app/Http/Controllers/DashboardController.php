<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\Stock;
use App\Models\Almacen;
use App\Models\Movimiento;
use App\Models\unidades_de_produccion;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\ElseIf_;

class DashboardController extends Controller
{
    public function index()
    {
        // Datos básicos para el dashboard
        $totalInsumos = Insumo::count();
        $totalStocks = Stock::where('estado', 'utilizable')->sum('cantidad');
        $almacenesActivos = Almacen::count();
        $proveedoresActivos = Proveedor::count();
        $unidadesProduccion = unidades_de_produccion::count();

        // Movimientos recientes (últimos 5)
        $movimientosRecientes = Movimiento::with(['user', 'stock.insumo'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Stocks próximos a vencer (en los próximos 30 días)
        $stocksProximosAVencer = Stock::where('estado', 'utilizable')
            ->where('fecha_de_vencimiento', '<=', now()->addDays(30))
            ->where('fecha_de_vencimiento', '>=', now())
            ->count();

        // Rol del usuario autenticado
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
                $rol = 'Administrador';
                break;
            case 'lider de la unidad':
                $rol = 'Líder de la Unidad';
                break;
            case 'instructor':
                $rol = 'Instructor';
                break;
            case 'aprendiz':
                $rol = 'Aprendiz';
                break;
            default:
                $rol = 'Desconocido';
        }
        // Datos para pasar a la vista
        $dashboardData = [
            'total_insumos' => $totalInsumos,
            'total_stocks' => $totalStocks,
            'almacenes_activos' => $almacenesActivos,
            'proveedores_activos' => $proveedoresActivos,
            'unidades_produccion' => $unidadesProduccion,
            'movimientos_recientes' => $movimientosRecientes,
            'stocks_proximos_a_vencer' => $stocksProximosAVencer,
            'user_name' => $user->name,
            'user_role' => $rol,
        ];

        return view('dashboard', compact('dashboardData'));
    }
}