<?php

namespace Forge\Alloy;


class Alloy
{
    protected $modules = [];
    protected $config;

    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->getDefaultConfig(), $config);
    }

    // Initialiser un module spécifique
    public function loadModule(string $moduleName)
    {
        $moduleClass = "Alloy\\Modules\\{$moduleName}";

        if (class_exists($moduleClass)) {
            $this->modules[$moduleName] = new $moduleClass();
            return $this;
        }

        throw new \Exception("Module {$moduleName} non trouvé.");
    }

    // Exécuter une tâche spécifique sur un module
    public function executeModuleTask(string $moduleName, string $task)
    {
        if (!isset($this->modules[$moduleName])) {
            throw new \Exception("Module {$moduleName} non chargé.");
        }

        $module = $this->modules[$moduleName];

        if (method_exists($module, $task)) {
            $module->{$task}();
        } else {
            throw new \Exception("Tâche {$task} non trouvée dans le module {$moduleName}.");
        }
    }

    // Obtenir la configuration par défaut d'Alloy
    private function getDefaultConfig()
    {
        return [
            'log_path' => __DIR__ . '/logs/alloy.log',
        ];
    }

    // Obtenir les modules chargés
    public function getModules(): array
    {
        return $this->modules;
    }
}
