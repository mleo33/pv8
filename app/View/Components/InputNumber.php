<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputNumber extends Component
{
    public $model;
    public $align;

    public function __construct($model, $align = 'center')
    {
        $this->model = $model;
        $this->align = $align;
    }

    public function render()
    {
        return view('components.input-number');
    }
}
