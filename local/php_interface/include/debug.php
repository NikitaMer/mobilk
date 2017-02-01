<?
 /**
 *
 * @param mixed $data
 * @param string $file
 * @return void
 *
 * */

function logger($data, $file) {
    file_put_contents(
        $file,
        var_export($data, 1)."\n",
        FILE_APPEND
    );
}
?>