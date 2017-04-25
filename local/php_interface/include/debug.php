<?
 /**
 *
 * @param mixed $data
 * @param string $file
 * @return void
 *
 * */

function logger($data, $file = "log.log") {
    $file = $_SERVER['DOCUMENT_ROOT'].'/'.$file;
    file_put_contents(
        $file,
        var_export($data, 1)."\n",
        FILE_APPEND
    );
}

 /**
 *
 * @param mixed $data
 * @param bool $admin_check
 * @return void
 *
 * */

function arshow($data, $admin_check = true){
    global $USER;
    $USER = new Cuser;
    if ($adminCheck) {
        if (!$USER->IsAdmin()) {
            return false;
        }
    }
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
?>