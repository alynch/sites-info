# Create a middleware that logs every request to the database

https://pusher.com/tutorials/realtime-analytics-dashboard-laravel

# Testing API endpoints

https://blog.pusher.com/tests-laravel-applications/


# PHPunit errors
PHPunit assertions might fail when using faker to create names, as it might use apostrophes, and blade converts 
them to HTML entities. We need to use the e() function to make this conversion in the assertion.

https://laracasts.com/discuss/channels/testing/testing-and-apostrophe-characters-in-fields


# Some PHP functions to get server information

php_uname();

phpversion ([ string $extension ] )


    protected function databaseInfo()
    {
        $pdo = $this->database->getConnection()->getPdo();
        $version = $this->ifExists($pdo->getAttribute(PDO::ATTR_SERVER_VERSION));
        $driver = $this->ifExists($pdo->getAttribute(PDO::ATTR_DRIVER_NAME));
        $driver = $this->ifExists((! empty($this->databases[$driver]) ? $this->databases[$driver] : null));
        $this->results['database'] = compact('driver', 'version');
        return $this;
    }



        $os = $this->ifExists($linfo->getOS());
        $kernel = $this->ifExists($linfo->getKernel());
        $arc = $this->ifExists($linfo->getCPUArchitecture());
        $webserver = $this->ifExists($linfo->getWebService());
        $php = $this->ifExists($linfo->getPhpVersion());

