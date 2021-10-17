<?php

namespace Azuriom\Plugin\PlayerFlash\Providers;

use Azuriom\Extensions\Plugin\BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function loadRoutes()
    {
        Route::prefix('player')
            ->middleware('web')
            ->name('player.')
            ->group(plugin_path($this->plugin->id.'/routes/web.php'));

        Route::prefix('admin/player')
            ->middleware('admin-access')
            ->name('player.admin.')
            ->group(plugin_path($this->plugin->id.'/routes/admin.php'));

        Route::prefix('api/'.$this->plugin->id)
            ->middleware('api')
            ->name($this->plugin->id.'.api.')
            ->group(plugin_path($this->plugin->id.'/routes/api.php'));
    }
}
