<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component {
    public string $label;
    public string $name;
    public string $id;
    public string $placeholder;
    public ?string $value;
    public ?bool $required;
    public ?bool $disabled;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $label,
        string $name,
        string $id,
        string $placeholder,
        ?string $value = null,
        ?bool $required = false,
        ?bool $disabled = false
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string {
        return view('components.form.select');
    }
}
