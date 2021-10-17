<?php

namespace Azuriom\Plugin\PlayerFlash\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Azuriom\Models\Setting;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('player-flash::admin.index', [
            "database" => [
                "host" => setting("second_database_host", ""),
                "port" => setting("second_database_port", ""),
                "dbname" => setting("second_database_dbname", ""),
                "username" => setting("second_database_username", ""),
                "password" => setting("second_database_password", "")
            ],
            "minecraft" => setting("server_adresse", "")
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        Setting::updateSettings([
            'second_database_host' => $request->input("host"),
            'second_database_port' => $request->input("port"),
            'second_database_dbname' => $request->input("dbname"),
            'second_database_username' => $request->input("username"),
            'second_database_password' => $request->input("password"),
            'server_adresse' => $request->input("ip")
        ]);
        return redirect()->route('player.admin.home')
            ->with('success', "Data save");
    }


}
