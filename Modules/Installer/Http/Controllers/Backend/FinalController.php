<?php


namespace Modules\Installer\Http\Controllers\Backend;

use Illuminate\Routing\Controller;
use Modules\Installer\Events\LaravelInstallerFinished;
use Modules\Installer\Helpers\EnvironmentManager;
use Modules\Installer\Helpers\FinalInstallManager;
use Modules\Installer\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param  \RachidLaasri\LaravelInstaller\Helpers\InstalledFileManager  $fileManager
     * @param  \RachidLaasri\LaravelInstaller\Helpers\FinalInstallManager  $finalInstall
     * @param  \RachidLaasri\LaravelInstaller\Helpers\EnvironmentManager  $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('installer::backend.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
