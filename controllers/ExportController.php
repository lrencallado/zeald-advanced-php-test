<?php
namespace app\controllers;

use Illuminate\Support;  // https://laravel.com/docs/5.8/collections - provides the collect methods & collections class
use LSS\Array2Xml;
use app\models\Exporter;
use app\core\Request;

class ExportController {

    public $args;
    public function __construct() {
        
    }

    public function export(Request $request) {

        $this->args = $request->getHeader();

        $format = $this->args->pull('format') ?: 'html';
        $type = $this->args->pull('type');
        if (!$type) {
            exit('Please specify a type');
        }

        $data = [];
        $exporter = new Exporter();
        
        switch ($type) {
            case 'playerstats':
                $searchArgs = ['player', 'playerId', 'team', 'position', 'country'];
                $search = $this->args->filter(function($value, $key) use ($searchArgs) {
                    return in_array($key, $searchArgs);
                });
                $data = $exporter->getPlayerStats($search);
                break;
            case 'players':
                $searchArgs = ['player', 'playerId', 'team', 'position', 'country'];
                $search = $this->args->filter(function($value, $key) use ($searchArgs) {
                    return in_array($key, $searchArgs);
                });
                $data = $exporter->getPlayers($search);
                break;
        }
        if (!$data) {
            exit("Error: No data found!");
        }
        return $exporter->format($data, $format);
    }
}