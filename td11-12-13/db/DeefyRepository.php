<?php
namespace iutnc\deefy\db;

class DeefyRepository {
    private static array $config;
    private static ?\PDO $instance = null;

    public static function setConfig(string $file) : void {
        self::$config = parse_ini_file($file);
    }

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

    public static function getAllPlaylists() : array {
        $pdo = self::getInstance();
        $sql = "SELECT * FROM playlist";
        $result = $pdo->query($sql);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function savePlaylist(string $nom) : int {
        $pdo = self::getInstance();
        $sql = "INSERT INTO playlist (nom) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom]);
        return $pdo->lastInsertId();
    }

    public static function getAllTracks() : array {
        $pdo = self::getInstance();
        $sql = "SELECT * FROM track";
        $result = $pdo->query($sql);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function saveTrack(string $titre, string $file) : int {
        $pdo = self::getInstance();
        $sql = "INSERT INTO track (titre, file) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $file]);
        return $pdo->lastInsertId();
    }

    // Jointure version error management
    public static function addTrackToPlaylist(int $trackId, int $playlistId) : void {
        $pdo = self::getInstance();
        $sql = "INSERT INTO playlist2track (id_pl, id_track) VALUES (?, ?)";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$playlistId, $trackId]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new \Exception("Cette piste est déjà associée à la playlist.");
            } else {
                throw $e;
            }
        }
    }

    public static function getTracksForPlaylist(int $playlistId) : array {
        $pdo = self::getInstance();
        $sql = "SELECT t.id, t.titre, t.file
                  FROM playlist2track p2t
                  JOIN track t ON t.id = p2t.id_track
                  WHERE p2t.id_pl = ?";
        $result = $pdo->prepare($sql);
        $result->execute([$playlistId]);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }
}
