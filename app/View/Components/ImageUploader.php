<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageUploader extends Component {
    public string $name;
    public string $id;
    public string $title;
    public string $src;
    public string $width;
    public string $height;
    public string $help;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $id,
        string $title,
        string $src,
        string $width,
        string $height,
        string $help
    ) {
        $this->name = $name;
        $this->id = $id;
        $this->title = $title;
        $this->src = $src;
        $this->width = $width;
        $this->height = $height;
        $this->help = $help;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string {
        return view('components.image-uploader');
    }
}
