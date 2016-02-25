<?php
namespace ViewComponents\TestingHelpers\Installer;

use Composer\Script\Event;

class Installer extends AbstractInstaller
{
    protected function useExampleEnv()
    {
        $data = $this->readExampleEnv();

        $this->createEnv($this->provideEnvDefaults($data));
    }

    protected function provideEnvDefaults($values)
    {
        if ($this->projectDir !== $this->installerDir) {
            $values['WEB_SERVER_DOCROOT'] = 'vendor/view-components/testing-helpers/public';
        }
        return $values;
    }
    /**
     * @return array
     */
    protected function readExampleEnv()
    {
        $filePath = "$this->installerDir/.env.example";
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
            $out .= "$key=$value" . PHP_EOL;
        }
        return $out;
    }

    protected function createEnv($values)
    {
        $path = "$this->projectDir/.env";
        echo "\t Creating \"$path\"... ";
        $body = $this->buildEnv($values);
        file_put_contents($path, $body);
        echo 'Done.', PHP_EOL;
    }

    protected function bootstrap()
    {
        include_once __DIR__ . '/../../bootstrap/bootstrap.php';
    }

    protected function configureEnv()
    {

        $data = $this->provideEnvDefaults($this->readExampleEnv());
        $envData = $this->askValues($data);
        $envBody = "\t\t" . str_replace("\n", "\n\t\t", $this->buildEnv($envData));
        if (!$this->askYesNo("Configured values:\r\n$envBody\r\n\t Is it ok?", true)) {
            $this->configureEnv();
        } else {
            $this->createEnv($envData);
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
        echo "Installation finished.\r\n";
    }

    protected function createDatabase()
    {
        echo "\tInitializing Database... ";
        $pdo = \ViewComponents\TestingHelpers\dbConnection();
        $sql = file_get_contents($this->installerDir . '/fixtures/db.sql');
        $sql = str_replace('DB_NAME', getenv('DB_NAME'), $sql);
        foreach (explode(';', $sql) as $query) {
            if (!trim($query)) {
                continue;
            }
            // don't drop & create db for sqlite
            if (\ViewComponents\TestingHelpers\isSQLite() && (
                    strpos($query, 'DATABASE') !== false
                    || strpos($query, 'USE ') !== false
                )
            ) {
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
        echo "Done.", PHP_EOL;
    }
}

