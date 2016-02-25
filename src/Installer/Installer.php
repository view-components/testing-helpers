<?php
namespace ViewComponents\TestingHelpers\Installer;

use Composer\Script\Event;

class Installer extends AbstractInstaller
{
    protected function useExampleEnv()
    {
        $envFile = "$this->installerDir/.env.example";
        echo "\r\n\t Copying $envFile to \"$this->projectDir/.env\"\r\n";
        copy($envFile, "$this->projectDir/.env");
    }
    protected function parseEnv($filePath)
    {
        $exampleEnvLines = file($filePath);
        $data = [];
        foreach ($exampleEnvLines as $line) {
            $line = trim($line);
            if ($line[0] === '#' || empty($line)) continue;
            list($key, $value) = explode('=', $line);
            $data[$key] = $value;
        }
        return $data;
    }

    protected function buildEnv($data)
    {
        $out = '';
        foreach ($data as $key => $value) {
            $out.= "$key=$value" . PHP_EOL;
        }
        return $out;
    }

    protected function bootstrap()
    {
        include_once __DIR__ . '/../../bootstrap/bootstrap.php';
    }
    protected function configureEnv()
    {

        $data = $this->parseEnv("$this->installerDir/.env.example");
        $envBody  = $this->buildEnv($this->askValues($data));
        if (!$this->askYesNo("\r\n Configured values:\r\n$envBody. Use it [y] or repeat process[n]?  (default: y)", true)) {
            $this->configureEnv();
        } else {
            file_put_contents("$this->projectDir/.env", $envBody);
            echo "\r\n\t\"$this->projectDir/.env\" file created.\r\n";
        }
    }
    public function run()
    {
        if (file_exists("$this->projectDir/.env")) {
            if (false === $this->askYesNo('Application already installed. Reinstall?', false)) {
               goto finish;
            };
        }
        start:
        $answer = $this->askChoose([
            'Use default configuration, see .env.example file',
            'Configure'
        ]);
        if ($answer == 1) {
            $this->useExampleEnv();
        } else {
            $this->configureEnv();
        }
        $this->bootstrap();
        $this->createDatabase();
        finish:
        echo "\r\nDone.\r\n";
    }

    protected function createDatabase()
    {
        echo "Initializing Database...\r\n";
        $pdo = \ViewComponents\TestingHelpers\dbConnection();
        $sql = file_get_contents($this->installerDir . '/fixtures/db.sql');
        $sql = str_replace('DB_NAME', getenv('DB_NAME'), $sql);
        foreach(explode(';', $sql) as $query) {
            if (!trim($query)) {
                continue;
            }
            // don't drop & create db for sqlite
            if (\ViewComponents\TestingHelpers\isSQLite() && (
                    strpos($query, 'DATABASE') !== false
                    || strpos($query, 'USE ') !== false
                )) {
                continue;
            }
            try {
                $stmt = $pdo->prepare($query);
                $stmt->execute();
            } catch (\Exception $e) {
                echo $e;
                echo PHP_EOL, 'Query: ', $query;
                die();
            }
        }
        echo "Done Initializing Database...\r\n";
    }
}

