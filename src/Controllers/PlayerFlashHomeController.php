<?php

namespace Azuriom\Plugin\PlayerFlash\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\PlayerFlash\Helpers\MojangAPI;
use Azuriom\Plugin\PlayerFlash\Helpers\MinecraftServerInfoQueryTcp;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PayPalHttp\Serializer\Json;
use PDO;
use Azuriom\Models\Setting;
use stringEncode\Exception;

class PlayerFlashHomeController extends Controller
{
    /**
     * PlayerFlashHomeController constructor.
     */
    public function __construct()
    {
        if (config()->get('database.connections.pstat') === null) {
            abort_if(setting("second_database_host", "127.0.0.1") === null, 404);

            config()->set('database.connections.pstat', [
                'driver' => 'mysql',
                'host' => setting("second_database_host", "127.0.0.1"),
                'port' => setting("second_database_port", "3306"),
                'database' => setting("second_database_dbname", "flashh"),
                'username' => setting("second_database_username"),
                'password' => setting("second_database_password"),
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
                'strict' => false
            ]);
        }
    }

    /**
     * Show the home plugin page.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('player-flash::index');
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function show(Request $request)
    {
        $uuid = MojangAPI::formatUuid(MojangAPI::getUuid($request["lastName"]));
        $user = DB::connection("pstat")->select("SELECT * FROM `accounts` WHERE uuid='" .
            $uuid . "' LIMIT 1");
        if (!boolval($user))
            return view('player-flash::index');
        else
            $user = json_decode($user["0"]->account);
        $stat = DB::connection("pstat")->select("SELECT * FROM `player_stats` WHERE uuid='" . $user->uuid . "' LIMIT 1;");
        $stat = $stat ? json_decode($stat[0]->stats) : false;
        $McInfo = new MinecraftServerInfoQueryTcp(setting("server_adresse", 'aquilae.pixelads.fr'));
        return view("player-flash::player", [
            "stat" => $this->statToDict($stat->stats),
            "pseudo" => $request["lastName"],
            "user" => $user,
            "isOnline" => !$McInfo->error && $this->playerIsOnline($McInfo->Players, $uuid)
        ]);
    }

    /**
     * @param $players
     * @param $uuid
     * @return bool
     */
    private function playerIsOnline($players, $uuid)
    {
        foreach ($players as $dataPlayer) {
            if ($dataPlayer["id"] == $uuid)
                return true;
        }
        return false;
    }

    /**
     * @param $stats
     * @return array
     */
    private function statToDict($stats)
    {
        $data = [];
        foreach ($stats as $stat) {
            $data[$stat->game] = $stat;
        }
        return $data;
    }
}
