<?php
    function isYesterday($timestamp, $timezone = null) {
        $t = new DateTime(null, $timezone);
        $t->setTimestamp($timestamp);
        $t->setTime(0,0);
        $yesterday = new DateTime("now", $timezone);
        $yesterday->setTime(0,0);
        $yesterday = $yesterday->sub(new DateInterval('P1D'));
    
        return $t == $yesterday;
    }
    
    $tk = "-----------------------------REDACTED-----------------------------";
    $uuid = "-----------------------------REDACTED-----------------------------";
    $raw = file_get_contents("https://api.hypixel.net/player?uuid=".$uuid."&key=".$tk);
    $json = json_decode($raw);
    $player = $json->player;
    $lastClaim = ($player->lastClaimedReward)/1000;
    unset($tk);
    unset($uuid);
    unset($raw);
    unset($json);
    unset($player);
    if (isYesterday($lastClaim)) {
        $webhookurl = "-----------------------------REDACTED-----------------------------";
        $YourDiscordID = "-----------------------------REDACTED-----------------------------";
        
        $json_data = json_encode([
            "content" => "<@".$YourDiscordID."> did **NOT** do the daily reward :alarm_clock:
        \n\n> **PLEASE remind!!**",
            "username" => "YOURNAME's daily reward",
            "avatar_url" => "PROFILEURLIMAGE.png",
            "tts" => true,
        
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        
        $ch = curl_init( $webhookurl );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        
        $response = curl_exec( $ch );
        curl_close( $ch );
        
        echo "DO > ".$lastClaim." [".date('d/m/Y', $lastClaim)."]";
    } else {
        echo "DONE > ".$lastClaim." [".date('d/m/Y', $lastClaim)."]";
    }
?>
