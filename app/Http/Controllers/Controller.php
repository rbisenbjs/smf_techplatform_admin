<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Organisation;
use Illuminate\Support\Facades\Auth;
use App\StructureMaster;
use App\MachineMaster;
use App\MachineMou;
use Illuminate\Support\Facades\DB;
use App\Survey;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Sets database configuration
     *
     * @param string $orgId
     * @return array
     */
    public function connectTenantDatabase($orgId = null)
    {
		$orgId = '5c1b940ad503a31f360e1252';
        if ($orgId instanceof Organisation) {
            $organisation = $orgId;
        } else {
            if ($orgId === null) {
                $orgId = Auth::user()->org_id;
            }
			
            $organisation = Organisation::find($orgId);
        }

        $dbName = $organisation->name . '_' . $organisation->id;
        $mongoDBConfig = config('database.connections.mongodb');
        $mongoDBConfig['database'] = $dbName;
        \Illuminate\Support\Facades\Config::set(
            'database.connections.' . $dbName,
            $mongoDBConfig
        );
        DB::setDefaultConnection($dbName);
        return [$orgId, $dbName];
    }

    public function importCSVData($model)
    {
        switch ($model) {
            case $model === StructureMaster::class:
                $this->importDataInStructureMaster();
                break;
            case $model === MachineMaster::class:
                $this->importDataInMachineMaster();
                break;
            case $model === MachineMou::class:
                $this->importDataInMachineMou();
                break;
        }
        return true;
    }

    public function importDataInStructureMaster()
    {
        $filePath = public_path('master-data/structure_master.csv');
        $data = $this->csvToArray($filePath);
        for ($i = 0; $i < count($data); $i++) {
            $structureMaster = StructureMaster::firstOrCreate($data[$i]);
            if (isset($data[$i]['state'])) {
                $state = \App\State::where('name', $data[$i]['state'])->first();
                $structureMaster->state()->associate($state);
            }
            if (isset($data[$i]['district'])) {
                $district = \App\District::where('name', $data[$i]['district'])->first();
                $structureMaster->district()->associate($district);
            }
            if (isset($data[$i]['taluka'])) {
                $taluka = \App\Taluka::where('name', $data[$i]['taluka'])->first();
                $structureMaster->taluka()->associate($taluka);
            }
            if (isset($data[$i]['village'])) {
                $village = \App\Village::where('name', $data[$i]['village'])->first();
                $structureMaster->village()->associate($village);
            }
            $structureMaster->save();
        }
        return true;
    }

    public function importDataInMachineMaster()
    {
        $filePath = public_path('master-data/machine_master.csv');
        $data = $this->csvToArray($filePath);
        for ($i = 0; $i < count($data); $i++) {
            $machineMaster = MachineMaster::firstOrCreate($data[$i]);
            if (isset($data[$i]['state'])) {
                $state = \App\State::where('name', $data[$i]['state'])->first();
                $machineMaster->state()->associate($state);
            }
            if (isset($data[$i]['district'])) {
                $district = \App\District::where('name', $data[$i]['district'])->first();
                $machineMaster->district()->associate($district);
            }
            if (isset($data[$i]['taluka'])) {
                $taluka = \App\Taluka::where('name', $data[$i]['taluka'])->first();
                $machineMaster->taluka()->associate($taluka);
            }
            $machineMaster->save();
        }
        return true;
    }

    public function importDataInMachineMou()
    {
        $filePath = public_path('master-data/machine_mou.csv');
        $data = $this->csvToArray($filePath);
        for ($i = 0; $i < count($data); $i++) {
            $machineMou = MachineMou::firstOrCreate($data[$i]);
            if (isset($data[$i]['state'])) {
                $state = \App\State::where('name', ucfirst(strtolower($data[$i]['state'])))->first();
                $machineMou->state()->associate($state);
            }
            if (isset($data[$i]['district'])) {
                $district = \App\District::where('name', ucfirst(strtolower($data[$i]['district'])))->first();
                $machineMou->district()->associate($district);
            }
            $machineMou->save();
        }
        return true;
    }

    private function csvToArray($filename)
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 10000)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }

    public function importDataIntoLocation()
    {
        $filePath = public_path('master-data/locations.csv');
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return false;
        }
        $header = null;
        $data = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 5000)) !== false) {
                $location = \App\Location::create(['jurisdiction_type_id' => '5c6a331948b6714224001917']);

                $state = \App\State::find($row[0]);
                $district = \App\District::find($row[1]);
                $taluka = \App\Taluka::find($row[2]);
                $village = \App\Village::find($row[3]);

                $location->state()->associate($state);
                $location->district()->associate($district);
                $location->taluka()->associate($taluka);
                $location->village()->associate($village);
                $location->save();
            }
            fclose($handle);
        }

        return true;
    }
	
	/**
	* Set log file path for all models
	* $param $orgId string 
	* $param $projectId string 
	* $param $modelName string 
	* $param $type string
	* return boolan true
	*/
	public function logInfoData($orgId,$projectId,$modelName,$type){
		
		$this->log = new Logger('name');
		////$orgId = \Illuminate\Support\Facades\Session::get('selectedOrg');
		//$projectId = \Illuminate\Support\Facades\Session::get('selectedProject');
		$logPah = "\logs\\".$orgId."\\".$projectId."\\".$modelName."\\". $type."\\"."logs_".date('Y-m-d').'.log';
		$storage_path = storage_path();		
		$this->log->pushHandler(new StreamHandler($storage_path.$logPah));
		return true;		
	}
	
	
	/**
	* Set log file path for all models
	* $param $orgId string 
	* $param $projectId string 
	* $param $modelName string 
	* $param $type string
	* return boolan true
	*/
	public function logErrorPath($modelName){
		
		$this->log = new Logger('name');
		$orgId = \Illuminate\Support\Facades\Session::get('selectedOrg');
		$projectId = \Illuminate\Support\Facades\Session::get('selectedProject');
		$type = 'Error';
		$logPah = "\logs\\".$orgId."\\".$projectId."\\".$modelName."\\". $type."\\"."logs_".date('Y-m-d').'.log';
		$storage_path = storage_path();	
			
		//$this->log->pushHandler(new StreamHandler($storage_path.$logPah));
		return $storage_path.$logPah;		
	}
	
	
}
