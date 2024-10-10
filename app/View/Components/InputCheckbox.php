<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputCheckbox extends Component
{
    public $model;
    public $value;

    public function __construct($model, $value = 'true')
    {
        $this->model = $model;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.input-checkbox');
    }
}