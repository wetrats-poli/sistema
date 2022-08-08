<?php
        
        // create a new cURL resource
        $ch = curl_init();
        $headers = array(
          'authority' => 'voting.playbuzz.com',
          'origin' => 'https://www.revistabeat.com.br',
          'user-agent' => 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36',
          'accept' => '*/*',
          'sec-fetch-site' => 'cross-site',
          'sec-fetch-mode' => 'cors',
          'referer' => 'https://www.revistabeat.com.br/2019/12/12/beat-de-ouro-2019/',
          'accept-encoding' => 'gzip, deflate, br',
          'accept-language' => 'pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
          'if-none-match' => 'W/^\^f6-FSzEWPkcOt35Yjt7SMKyod3JNwI^\^'
      );
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, 'https://voting.playbuzz.com/poll/4ac71c00-0613-4bfa-aed3-50c8efebc9eb/12a80d55-6d5f-430c-bf45-d68e9f562063?questionId=12a80d55-6d5f-430c-bf45-d68e9f562063');
        curl_setopt($ch, CURLOPT_HEADER, $headers);
        ob_start();
        // grab URL and pass it to the browser
        curl_exec($ch);
        $resposta = ob_get_clean();
        //$resposta=json_decode($resposta, true);
        //$total=count($resposta);
        $resposta = explode('"results":',$resposta)[1];
        $resposta=substr($resposta,0,-1);
        $resposta = json_decode($resposta,true);
        $ayumi=$resposta['e28189de-6282-4dad-9465-012cd70e16b5'];
        $cha=$resposta['80625d79-bc79-4b8e-a9c9-c733e3721c71'];
        echo "<br>Ayumi:".$ayumi."<br>";
        echo "Cha:".$cha;
        //$con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
        //$sql =  "INSERT INTO beat(cha,ayumi) VALUES (".$cha.",".$ayumi.")";
        //mysqli_query($con,$sql);
        
        // close cURL resource, and free up system resources
        curl_close($ch);
    
        ?>