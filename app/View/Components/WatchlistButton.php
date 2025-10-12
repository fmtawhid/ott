<?php
namespace App\View\Components;

use Illuminate\View\Component;

class WatchlistButton extends Component
{
    public $entertainmentId;
    public $inWatchlist;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($entertainmentId, $inWatchlist)
    {
        $this->entertainmentId = $entertainmentId;
        $this->inWatchlist = $inWatchlist;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.watchlist-button');
    }
}
