<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/scripts/globals.php");

class RestUtils
{
    function __construct()
    {
        $conf = array('mode' => 0600, 'timeFormat' => '%X %x');
    }

    public static function SendAnyGetRequest($url)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, '3');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $content = trim(curl_exec($ch));

        //todo $curlError = curl_error($ch);

        curl_close($ch);
        return $content;
    }

    private static function sendAnyRequest($url, $obj)
    {
        $getData = http_build_query($obj);


        RestLogger::log("RestUtils::sendAnyRequest url: ".$url." data: ".$getData);

        $opts = array('http' =>
        array(
            'method' => 'GET',
            'content' => $getData
        )
        );

        $context = stream_context_create($opts);

        $response = file_get_contents($url, false, $context);

        RestLogger::log("RestUtils::sendAnyRequest response: ".$response);

        return $response;

    }

    private static function sendRequest($urlExtension, $id, $obj)
    {
        $url = $GLOBALS["restURL"]."/CatBee/{$urlExtension}";
        if (isset($id)) {
            $url .= $id;
        }

        return RestUtils::sendAnyRequest($url, $obj);
    }


    public function SendFreeUrlRequest($url, $obj)
    {
        return RestUtils::sendAnyRequest($url, $obj);

    }

    public static function SendComponentRequest($comp, $id, $obj)
    {
        return RestUtils::sendRequest('components/'.$comp, $id, $obj);

    }

    public static function SendGetRequest($api, $id, $obj)
    {
        return RestUtils::sendRequest('api/'.$api.'/', $id, $obj);

    }

    public static function SendFreePostRequest($url, $obj)
    {
        set_time_limit(60);
        $postData = http_build_query($obj);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        RestLogger::log('SendFreePostRequest response ', $response);

        $headers = curl_getinfo($ch);
        RestLogger::log('SendFreePostRequest response headers', $headers);

        curl_close($ch);

        return $response;

    }

    public static function SendPostRequest($api, $id, $obj)
    {
        set_time_limit(0);
        $url = $GLOBALS["restURL"]."/CatBee/api/{$api}/";

        if (isset($id)) {
            $url .= $id;
        }

        RestLogger::log("RestUtils::SendPostRequest Before send post: ".$url);

        $postData = http_build_query($obj);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    public static function SendPostRequestAndReturnResult($api, $id, $obj)
    {
        $url = $GLOBALS["restURL"]."/CatBee/api/{$api}/";

        if (isset($id)) {
            $url .= $id;
        }

        RestLogger::log("RestUtils::SendPostRequest Before send post: ".$url);

        $postData = http_build_query($obj);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    public static function processRequest()
    {
        // get our verb
        $request_method = strtolower($_SERVER['REQUEST_METHOD']);
        $return_obj = new RestRequest();
        // we'll store our data here
        $data = array();

        switch ($request_method) {
            // gets are easy...
            case 'get':
                $data = $_GET;
                break;
            // so are posts
            case 'post':
                $data = $_POST;
                break;
            // here's the tricky bit...
            case 'put':
                // basically, we read a string from PHP's special input location,
                // and then parse it out into an array via parse_str... per the PHP docs:
                // Parses str  as if it were the query string passed via a URL and sets
                // variables in the current scope.
                parse_str(file_get_contents('php://input'), $put_vars);
                $data = $put_vars;
                break;
        }

        // store the method
        $return_obj->setMethod($request_method);

        // set the raw data, so we can access it if needed (there may be
        // other pieces to your requests)

        RestLogger::log("RestUtils::processRequest ", $data);

        $return_obj->setRequestVars($data);

        if (isset($data['data'])) {
            // translate the JSON to an Object for use however you want
            $return_obj->setData(json_decode($data['data']));
        }
        return $return_obj;
    }

    public static function sendSuccessResponse($params = null)
    {
        if ($params)
        {
            RestUtils::sendResponse(200, $params);
        }
        else
        {
            RestUtils::sendResponse(200, array('status' => 'ok'));
        }
    }

    public static function sendFailedResponse($reason)
    {
        RestUtils::sendResponse(0, array('status' => 'failed', 'reason' => $reason));
    }

    public static function sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . RestUtils::getStatusCodeMessage($status);
        // set the status
        header($status_header);
        // set the content type
        header('Content-type: ' . $content_type);

        // pages with body are easy
        if ($body != '') {
            // send the body
            if (is_array($body)) {
                $bodyStr = stripslashes(json_encode($body));
            } else {
                $bodyStr = $body;
            }

            echo $bodyStr;
            exit;
        } // we need to create the body if none is passed
        else {
            // create some body messages
            $message = '';

            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch ($status) {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            // servers don't always have a signature turned on (this is an apache directive "ServerSignature On")
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

            // this should be templatized in a real-world solution
            $body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
                    <html>
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                            <title>' . $status . ' ' . RestUtils::getStatusCodeMessage($status) . '</title>
                        </head>
                        <body>
                            <h1>' . RestUtils::getStatusCodeMessage($status) . '</h1>
                            <p>' . $message . '</p>
                            <hr />
                            <address>' . $signature . '</address>
                        </body>
                    </html>';

            echo $body;
            exit;
        }
    }

    public static function getStatusCodeMessage($status)
    {
// these could be stored in a .ini file and loaded
// via parse_ini_file()... however, this will suffice
// for an example
        $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        return (isset($codes[$status])) ? $codes[$status] : '';
    }
}

class RestRequest
{
    private $request_vars;
    private $data;
    private $http_accept;
    private $method;

    public function __construct()
    {
        $this->request_vars = array();
        $this->data = '';
        $this->http_accept = (strpos($_SERVER['HTTP_ACCEPT'], 'json')) ? 'json' : 'xml';
        $this->method = 'get';
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function setRequestVars($request_vars)
    {
        $this->request_vars = $request_vars;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getHttpAccept()
    {
        return $this->http_accept;
    }

    public function getRequestVars()
    {
        return $this->request_vars;
    }

    public function getCatBeeContext()
    {
        if (isset($this->request_vars["context"]))
        {
            if (is_array($this->request_vars["context"]))
            {
                return $this->request_vars["context"];
            }
            else
            {
                return json_decode($this->request_vars["context"], true);
            }
        }
        return "<context not defined>";
    }

    public function getCatBeeCredentials()
    {
        if (isset($this->request_vars["app"]))
        {
            return $this->request_vars["app"];
        }
        return "<[Credentials] not defined>";
    }

    public function getCatBeeAction()
    {
        if (isset($this->request_vars["action"]))
        {
            return str_replace(' ', '', strtolower($this->request_vars["action"]));
        }
        return "<action not defined>";
    }
}