<?php
namespace iutnc\deefy;

class Autoloader {
    private string $prefix;
    private string $baseDir;

    public function __construct(string $prefix, string $baseDir) {
        $this->prefix = trim($prefix, '\\') . '\\';
        $this->baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public function loadClass(string $className): void {
        // Vérifie le préfixe
        $len = strlen($this->prefix);
        if (strncmp($this->prefix, $className, $len) !== 0) return;

        // Namespace relatif (sans le préfixe)
        $relativeClass = substr($className, $len);

        // Remplace \ par /
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