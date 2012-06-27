<?php

/**
 * Validates email addresses in the backround as cli script
 *
 * @todo Implement array storage could be database, redis or extened Laravel config to save to file
 * @todo Implement send verification email
 * @todo if $code is 250 remove email from array and set access value for user
 * @todo increment a counter and max tries
 * @todo array storage will hold mx okay, socket okay or increment for failed, email verificaarion code send
 *
 */

function validate_email($email) {

    list($alias, $domain) = split("@", $email);

    if (function_exists("getmxrr") && getmxrr($domain, $mxhosts)) {
        foreach ($mxhosts as $mxhost) {
            $code = checkMX($mxhost, $email);
            switch ($code) {
                case 451 :
                    $bestcode = 451;
                    // Grey Listing
                    break;
                case 250 :
                    // Okay accepted we have a winner
                    $bestcode = 250;
                    // update users session access level
                    // send user a flash message about the update
                    // update users account access level
                    // remove email address from validation array
                    return TRUE;
                    break;
                default :
                    // host not found
                    if (!isset($bestcode))
                        $bestcode = 0;
            }
        }
        return $bestcode;
    }
}

function checkMX($mxhost, $email) {
    $code = 0;
    $fp = @fsockopen($mxhost, 25, $errno, $errstr, 2);
    if ($fp) {
        send_command($fp, 'HELO microsoft.com');
        send_command($fp, 'MAIL FROM:<support@microsoft.com>');
        $erg = send_command($fp, 'RCPT TO:<' . $email . '>');
        fclose($fp);
        $code = intval(substr($erg, 0, 3));
    }
    return $code;
}
?>