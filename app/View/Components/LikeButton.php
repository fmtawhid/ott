<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LikeButton extends Component
{
    public $entertainmentId;
    public $isLiked;
    public $type;

    /**
     * Create a new component instance.
     *
     * @param  int  $entertainmentId
     * @param  bool  $isLiked
     * @return void
     */
    public function __construct($entertainmentId, $isLiked, $type)
    {
        $this->entertainmentId = $entertainmentId;
        $this->isLiked = $isLiked;
        $this->type = $type;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.like-button');
    }
}
