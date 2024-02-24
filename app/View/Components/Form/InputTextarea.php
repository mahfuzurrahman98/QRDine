<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputTextarea extends Component {
    public string $label;
    public string $name;
    public string $id;
    public string $value;
    public string $placeholder;
    public bool $required;
    public bool $disabled;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $label,
        string $name,
        string $id,
        string $value,
        string $placeholder,
        bool $required = false,
        bool $disabled = false
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string {
        return view('components.form.input-textarea');
    }
}
