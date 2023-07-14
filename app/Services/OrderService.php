<?php

namespace App\Services;

use App\Models\Sale;

class OrderStatus
{
    const ENESPERA = 'En espera';
    const ENPREPARACION = 'En preparación';
    const ESPERANDODELIVERY = 'Esperando delivery';
    const ENTREGADO = 'Entregado';
    const CANCELADO = 'Cancelado';
}
class OrderService
{
    public function change_status(int $order_id, $status)
    {
        $order = Sale::findOrFail($order_id);
        if ($order) {
            try {
                $order->status = $status;
                $order->save();
                return true;
            } catch (\Throwable $th) {
                report($th);
            }
        }
        return false;
    }
}
