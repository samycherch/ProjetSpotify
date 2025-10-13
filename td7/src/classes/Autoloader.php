<?php
namespace loader;

class Autoloader {
    private string $prefix;
    private string $baseDir;

    public function __construct(string $prefix, string $baseDir) {
        $this->prefix = trim($prefix, '\\') . '\\';
        $this->baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public function loadClass(string $className): void {
        $len = strlen($this->prefix);
        if (strncmp($this->prefix, $className, $len) !== 0) return;

        
        $relativeClass = substr($className, $len);

        
        $file = $this->baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

        if (is_file($file)) {
            require_once $file;
        }
    }

    public function register(): void {
        spl_autoload_register([$this, 'loadClass']);
    }
}
?>