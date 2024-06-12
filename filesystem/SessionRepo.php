<?php

namespace filesystem;

/**
 * Sessionのリポジトリ
 *
 * phpの標準機能ではtmpファイルを作成してsessionを保持する
 */
class SessionRepo implements \auth\SessionRepo
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function get(): ?\auth\Session
    {
        if (!isset($_SESSION['session'])) {
            return null;
        }

        // FIXME: ワンチrceになるので直す
        //  https://blog.orange.tw/search?updated-max=2019-01-16T20:10:00%2B08:00&max-results=5&start=10&by-date=false
        $session = unserialize($_SESSION['session']);

        if ($session instanceof \auth\Session) {
            return $session;
        }

        return null;
    }

    public function set(\auth\Session $session)
    {
        $_SESSION['session'] = serialize($session);
    }

    public function delete()
    {
        $_SESSION['session'] = null;
    }
}
