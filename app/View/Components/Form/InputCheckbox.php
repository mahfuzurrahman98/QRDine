<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputCheckbox extends Component {
    public string $name;
    public string $id;
    public string $checked;
    public string $label;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $id,
        string $checked,
        bool $required,
        string $label
    ) {
        $this->name = $name;
        $this->id = $id;
        $this->checked = $checked;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string {
        return view('components.form.input-checkbox');
    }
}
