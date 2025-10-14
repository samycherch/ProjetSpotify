<?php
$nom_cookie = 'track';

if (!isset($_COOKIE[$nom_cookie])) {
    $track = ['album' => 'Popular Monster', 'artist' => 'Falling In Reverse', 'year' => 2019];

    $trackStr = serialize($track);

    setcookie($nom_cookie, $trackStr, time()+3600, '/');
    echo "Cookie track créé.";
} else {
    $track = unserialize($_COOKIE[$nom_cookie]);
    echo "Track : Album = " . $track['album'] . ", Artist = " . $track['artist'] . ", Year = " . $track['year'];
}
?>
