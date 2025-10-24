<?php
namespace iutnc\deefy\db;

class DeefyRepository {
    private static array $config;
    private static ?\PDO $instance = null;

    // Charge le fichier INI de config BDD
    public static function setConfig(string $file) : void {
        self::$config = parse_ini_file($file);
    }

    // Singleton : retourne l’instance PDO
    public static function getInstance() : \PDO {
        if (self::$instance === null) {
            $dsn = "mysql:host=" . self::$config['host'] .
                ";dbname=" . self::$config['db'] .
                ";charset=" . (self::$config['charset'] ?? 'utf8');
            self::$instance = new \PDO($dsn, self::$config['user'], self::$config['password']);
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }

    // Récupère toutes les playlists (table playlist)
    public static function getAllPlaylists() : array {
        $pdo = self::getInstance();
        $sql = "SELECT * FROM playlist";
        $result = $pdo->query($sql);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Sauvegarde une playlist (nom seulement)
    public static function savePlaylist(string $nom) : int {
        $pdo = self::getInstance();
        $sql = "INSERT INTO playlist (nom) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom]);
        return $pdo->lastInsertId();
    }

    // Sauvegarde une piste/track
    public static function saveTrack(string $titre, string $file) : int {
        $pdo = self::getInstance();
        $sql = "INSERT INTO track (titre, file) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $file]);
        return $pdo->lastInsertId();
    }

    // Lie une piste à une playlist
    public static function addTrackToPlaylist(int $trackId, int $playlistId) : void {
        $pdo = self::getInstance();
        $sql = "INSERT INTO playlist2track (idplaylist, idtrack) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$playlistId, $trackId]);
    }
}
