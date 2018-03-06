<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
    header("Content-Type:application/json");
    $fp =fopen("php://input","r");
    $data = "";
    while(!feof($fp)) {
        $data .= fgets($fp);
    }
    fclose($fp);
    $data = json_decode($data);
    $config = json_decode(file_get_contents("/var/www/conf/marvel.json"));
    if($data && $config) {
        $args = (array)$data->args;

        $args['apikey'] = $config->public;
        $args['ts'] = date('U');
        $args['hash'] = md5( $args['ts'] . $config->private . $args['apikey']);

        $ch = curl_init();
        $requestArgs = [];
        foreach($args as $param => $val) {
            $requestArgs[] = "{$param}={$val}";
        }

        //var_dump(urlencode(implode("&",$requestArgs))); exit;
        curl_setopt($ch,CURLOPT_URL,$data->url."?".implode("&",$requestArgs));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,[
            "Accept: application/json"
        ]);

        $ret = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if(!$ret) {
            $ret = json_encode([
                "code" => 404,
                "status" => "failed",
                "data" => [],
            ]);
        }
        echo $ret;
        http_response_code($info['http_code']);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(405);
}
