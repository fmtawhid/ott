<?php

namespace Modules\Installer\Http\Controllers\Backend;

use Illuminate\Routing\Controller;
use Modules\Installer\Helpers\DatabaseManager;

class DatabaseController extends Controller
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param  DatabaseManager  $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        $response = $this->databaseManager->migrateAndSeed();

        return redirect()->route('final')->with(['message' => $response]);

    }
}
