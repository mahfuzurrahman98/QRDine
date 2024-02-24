<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component {
    public string $type;
    public string $id;
    public string $usage;
    public string $size;
    public string $href;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $type,
        string $id,
        string $usage,
        ?string $size = 'normal',
        string $href = ''
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->usage = $usage;
        $this->size = $size;
        $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string {
        return view('components.button');
    }
}
