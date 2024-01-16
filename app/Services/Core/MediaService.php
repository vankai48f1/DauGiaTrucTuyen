<?php

namespace App\Services\Core;

use App\Models\Core\Medium;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    private $config;
    private $request;

    public function __construct()
    {
        $this->config = config('media');
        $this->request = request();
    }

    public function getUpLevelPath()
    {
        $currentPathArray = explode('/', $this->getCurrentPath());
        $upLevelPath = '';
        if (count($currentPathArray) > 1) {
            unset($currentPathArray[count($currentPathArray) - 1]);
            $upLevelPath = implode('/', $currentPathArray);
        }
        return $upLevelPath;
    }

    public function getCurrentPath()
    {
        if ($this->request->has('directory')) {
            return $this->getRootPath() . Str::startsWith($this->request->get('directory'), '/') ? $this->request->get('directory') : '/' . $this->request->get('directory');
        }elseif ($this->request->has('path')){
            return Str::endsWith($this->request->get('path'), '/') ? rtrim($this->request->get('path'), '/') : $this->request->get('path');
        }
        return $this->getRootPath();
    }

    public function getRootPath()
    {
        return $this->config['path'];
    }

    public function isDirectoryExists($name)
    {
        $directory = sprintf("%s/%s",$this->getCurrentPath(), $name);
        return Storage::disk($this->getDisk())->exists($directory);
    }

    public function makeDirectory($name)
    {
        $directory = sprintf("%s/%s",$this->getCurrentPath(), $name);
        return Storage::disk($this->getDisk())->makeDirectory($directory);
    }

    public function renameDirectory($oldName, $name)
    {
        $newDirectory = sprintf("%s/%s",$this->getCurrentPath(), $name);
        $oldDirectory = sprintf("%s/%s",$this->getCurrentPath(), $oldName);

        if(Storage::disk($this->getDisk())->move($oldDirectory, $newDirectory)){
            return Medium::where('path','like',$oldDirectory.'%')->update(['path'=>DB::raw('replace(path,"'.$oldDirectory.'","'.$newDirectory.'")')]);
        }
        return false;
    }

    public function deleteDirectory($name)
    {
        $directory = sprintf("%s/%s",$this->getCurrentPath(), $name);

        if(Storage::disk($this->getDisk())->deleteDirectory($directory)){
            return Medium::where('path','like',$directory.'%')->delete();
        }
        return false;
    }

    public function upload($file, $name)
    {
        return app(FileUploadService::class)->upload($file, $this->getCurrentPath(), $name, '', '', $this->getDisk(), null, null, true, $file->extension());
    }

    public function remove($path, $name)
    {
        $path = Str::endsWith($path, '/') ? rtrim($path, '/') : $path;
        $imagePath = sprintf("%s/%s", $path, $name);
        return Storage::disk($this->getDisk())->delete($imagePath);
    }

    public function getDisk()
    {
        return $this->config['disk'];
    }

    public function getDirectories()
    {
        return Storage::disk($this->getDisk())->directories($this->getCurrentPath());
    }

}
