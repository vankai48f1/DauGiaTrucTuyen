<?php

class PhpValetDriver extends ValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param string $sitePath
     * @param string $siteName
     * @param string $uri
     * @return bool
     */
    public function serves($sitePath, $siteName, $uri)
    {
        if (file_exists($sitePath.'/index.php')) {

             return true;
         }

        return false;
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param string $sitePath
     * @param string $siteName
     * @param string $uri
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
    	
        if (file_exists($staticFilePath = $sitePath . '/' . $uri)) {
        echo staticFilePath;
            return $staticFilePath;
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param string $sitePath
     * @param string $siteName
     * @param string $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        return $sitePath . '/index.php';
    }
}
