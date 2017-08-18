<?php
/**
 *
 * @author
 */
class ErrorSupervisor {
    protected $registry;

    public function __construct($registry) {
        $this->registry = $registry;
        // Catch error.
        set_error_handler(array($this, 'OtherErrorCatcher'));
        // Catch fatal error.
        register_shutdown_function(array($this, 'FatalErrorCatcher'));
// Buffering.
        ob_start();
    }

    public function OtherErrorCatcher($errno, $errstr) {
        $errorStr=$errno;
        file_put_contents(ERROR_FILE,$errorStr);
        return "Other Error".((DEBUG)?$errno:"");
    }

    public function FatalErrorCatcher() {
        $error = error_get_last();
        if (isset($error)) {
            if($error['type'] == E_ERROR
            || $error['type'] == E_PARSE
            || $error['type'] == E_COMPILE_ERROR
            || $error['type'] == E_CORE_ERROR) {
                return "Error".((DEBUG)?" Type# ".$error['type']." Msg# ".$error['message']:"");
                ob_end_clean(); // buffer clean
            } else {
                file_put_contents(ERROR_FILE,$error['message']);
                return "Fatal Error".(DEBUG?" Type# ".$error['type']." Msg# ".$error['message']:"");
                ob_end_flush(); // buffer print
            }
        } else {
            return "Unknown Error Registred";
            ob_end_flush(); // buffer print
        }
    }
}
