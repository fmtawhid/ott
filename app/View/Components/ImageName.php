<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImageName extends Component
{
    public $image;
    public $name;

    /**
     * Create a new component instance.
     *
     * @param string $image
     * @param string $name
     */
    public function __construct($image, $name)
    {
        $this->image = $image;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.image-name');
    }
}
