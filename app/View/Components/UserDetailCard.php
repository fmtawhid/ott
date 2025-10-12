<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserDetailCard extends Component
{
    public $name;
    public $email;
    public $image;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $email, $image)
    {
        $this->name = $name;
        $this->email = $email;
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.user-detail-card');
    }
}
