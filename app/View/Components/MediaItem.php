<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MediaItem extends Component
{
    public $thumbnail;
    public $name;
    public $genre;
    public $releaseDate;

    /**
     * Create a new component instance.
     *
     * @param string $thumbnail
     * @param string $name
     * @param string $genre
     * @param string $releaseDate
     */
    public function __construct($thumbnail, $name, $genre, $releaseDate)
    {
        $this->thumbnail = $thumbnail;
        $this->name = $name;
        $this->genre = $genre;
        $this->releaseDate = $releaseDate;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.media-item');
    }
}
