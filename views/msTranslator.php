<?php

/* 
http://msdn.microsoft.com/en-us/library/hh454950.aspx
http://msdn.microsoft.com/en-us/library/ff512385.aspx
*/

class AccessTokenAuthentication {
    /*
     * Get the access token.
     *
     * @param string $grantType    Grant type.
     * @param string $scopeUrl     Application Scope URL.
     * @param string $clientID     Application client ID.
     * @param string $clientSecret Application client ID.
     * @param string $authUrl      Oauth Url.
     *
     * @return string.
     */
    function getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl){
        try {
            //Initialize the Curl Session.
            $ch = curl_init();
            //Create the request Array.
            $paramArr = array (
                 'grant_type'    => $grantType,
                 'scope'         => $scopeUrl,
                 'client_id'     => $clientID,
                 'client_secret' => $clientSecret
            );
            //Create an Http Query.//
            $paramArr = http_build_query($paramArr);
            //Set the Curl URL.
            curl_setopt($ch, CURLOPT_URL, $authUrl);
            //Set HTTP POST Request.
            curl_setopt($ch, CURLOPT_POST, TRUE);
            //Set data to POST in HTTP "POST" Operation.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $paramArr);
            //CURLOPT_RETURNTRANSFER- TRUE to return the transfer as a string of the return value of curl_exec().
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
            //CURLOPT_SSL_VERIFYPEER- Set FALSE to stop cURL from verifying the peer's certificate.
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //Execute the  cURL session.
            $strResponse = curl_exec($ch);
            //Get the Error Code returned by Curl.
            $curlErrno = curl_errno($ch);
            if($curlErrno){
                $curlError = curl_error($ch);
                throw new Exception($curlError);
            }
            //Close the Curl Session.
            curl_close($ch);
            //Decode the returned JSON string.
            $objResponse = json_decode($strResponse);
            if (property_exists($objResponse, 'error')){
                throw new Exception($objResponse->error_description);
            }
            return $objResponse->access_token;
        } catch (Exception $e) {
            echo "Exception-".$e->getMessage();
        }
    }
}

try {
    //Client ID of the application.
    $clientID       = "wp-translate-box";
    //Client Secret key of the application.
    $clientSecret = "0KSTTMFy3s9Do8wDpn8rHwI3YKhx0gu+/uIc5DpVch0=";
    //OAuth Url.
    $authUrl      = "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/";
    //Application Scope Url
    $scopeUrl     = "http://api.microsofttranslator.com";
    //Application grant type
    $grantType    = "client_credentials";

    //Create the AccessTokenAuthentication object.
    $authObj      = new AccessTokenAuthentication();
    //Get the Access token.
    $accessToken  = $authObj->getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl);

    header("Content-Type: application/javascript");

    echo 'var lang = {};';
    echo "lang['ar'] = 'Arabic';";
    echo "lang['bg'] = 'Bulgarian';";
    echo "lang['ca'] = 'Catalan';";
    echo "lang['zh-CHS'] = 'Chinese (Simplified)';";
    echo "lang['zh-CHT'] = 'Chinese (Traditional)';";
    echo "lang['cs'] = 'Czech';";
    echo "lang['da'] = 'Danish';";
    echo "lang['nl'] = 'Dutch';";
    echo "lang['en'] = 'English';";
    echo "lang['et'] = 'Estonian';";
    echo "lang['fa'] = 'Persian (Farsi)';";
    echo "lang['fi'] = 'Finnish';";
    echo "lang['fr'] = 'French';";
    echo "lang['de'] = 'German';";
    echo "lang['el'] = 'Greek';";
    echo "lang['ht'] = 'Haitian Creole';";
    echo "lang['he'] = 'Hebrew';";
    echo "lang['hi'] = 'Hindi';";
    echo "lang['hu'] = 'Hungarian';";
    echo "lang['id'] = 'Indonesian';";
    echo "lang['it'] = 'Italian';";
    echo "lang['ja'] = 'Japanese';";
    echo "lang['ko'] = 'Korean';";
    echo "lang['lv'] = 'Latvian';";
    echo "lang['lt'] = 'Lithuanian';";
    echo "lang['mww'] = 'Hmong Daw';";
    echo "lang['no'] = 'Norwegian';";
    echo "lang['pl'] = 'Polish';";
    echo "lang['pt'] = 'Portuguese';";
    echo "lang['ro'] = 'Romanian';";
    echo "lang['ru'] = 'Russian';";
    echo "lang['sk'] = 'Slovak';";
    echo "lang['sl'] = 'Slovenian';";
    echo "lang['es'] = 'Spanish';";
    echo "lang['sv'] = 'Swedish';";
    echo "lang['th'] = 'Thai';";
    echo "lang['tr'] = 'Turkish';";
    echo "lang['uk'] = 'Ukrainian';";
    echo "lang['vi'] = 'Vietnamese';";

    echo 'window.mstranslator_accessToken = "'.$accessToken.'";';
    echo "window.mstranslator_langs = lang;";  

} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . PHP_EOL;
}
 
?>
