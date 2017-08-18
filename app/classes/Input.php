<?php
/* (C) Moriarti Engine */
/* writen by [SG](CP&WM#L)Moriarti */
/* last modify by [ANDS&SG](CP&WM#L)Moriarti at 23:33:26 05.05.2005 */
/* last modify by [ANDS&SG](CP&WM#L)Moriarti at 19:57:33 27.05.2005 */
/* last modify by [CS](CP&WM#SA#L)Moriarti at 23:49:54 11.11.2007 */
/* last modify by [CS](CP&WM#SA#L)Moriarti at 23:09:28 11.01.2008 */
/* build, rebuild, modify and optimize */
final class Input {
    private $r;

    public function __construct() {
        global $_GET, $_POST, $_REQUEST, $_COOKIE, $_SESSION;
        $r = array();
        if (is_array($_GET)) {
            while (list($key, $s) = each($_GET)) {
                if (is_array($_GET[$key])) {
                    while (list($key2, $s2) = each($_GET[$key])) {
                        $r[$key][$key2] = $this->protect($s2);
                    }
                } else {
                    $r[$key] = $this->protect($s);
                }
            }
        }

        if (is_array($_POST)) {
            while (list($key, $s) = each($_POST)) {
                if (is_array($_POST[$key])) {
                    while (list($key2, $s2) = each($_POST[$key])) {
                        $r[$key][$key2] = $this->protect($s2);
                    }
                } else {
                    $r[$key] = $this->protect($s);
                }
            }
        }
        if (is_array($_COOKIE)) {
            while (list($key, $s) = each($_COOKIE)) {
                if (is_array($_COOKIE[$key])) {
                    while (list($key2, $s2) = each($_COOKIE[$key])) {
                        $r['c_' . $key][$key2] = $this->protect($s2);
                    }
                } else {
                    $r['c_' . $key] = $this->protect($s);
                }
            }
        }
        if (is_array($_SESSION)) {
            while (list($key, $s) = each($_SESSION)) {
                if (is_array($_SESSION[$key])) {
                    while (list($key2, $s2) = each($_SESSION[$key])) {
                        $r['s_' . $key][$key2] = $this->protect($s2);
                    }
                } else {
                    $r['s_' . $key] = $this->protect($s);
                }
            }
        }
        $this->r = $r;
    }

    public function __toString() {
        return $this->r;
    }

    protected function protect($s) {
        $s = htmlspecialchars($s, ENT_QUOTES);
        $s = str_replace("&#032;", " ", $s);
        $s = str_replace("!", "&#33;", $s);
        $r = array("/\|/" => "&#124;", "/\\\$/" => "&#036;", "/\r/" => "", "/\n/" => "", "/\\\/" => "&#092;");
        foreach ($r as $k => $v) {
            $s = preg_replace($k, $v, $s);
        }
        return $s;
    }

    protected function protect_int($s) {
        $s = intval();
        return $s;
    }
}
?>
