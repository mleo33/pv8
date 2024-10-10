<?php

namespace App\Adminlte\menu_filters;

use App\Models\Renta;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class RentAlertFilter implements FilterInterface
{
    public function transform($item)
    {
        if (isset($item['data']) && $item['data'] == 'equipos_vencidos') {
            $count = Renta::equipos_proximo_vencimiento()->count();

            $item['label'] = $count;
            $item['label_color'] = 'danger';

            if($count <= 0){
                return;
            }
        }
        
        return $item;
    }
}