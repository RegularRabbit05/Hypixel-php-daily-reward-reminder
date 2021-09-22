<?php
2	    function isYesterday($timestamp, $timezone = null) {
3	        $t = new DateTime(null, $timezone);
4	        $t->setTimestamp($timestamp);
5	        $t->setTime(0,0);
6	        $yesterday = new DateTime("now", $timezone);
7	        $yesterday->setTime(0,0);
8	        $yesterday = $yesterday->sub(new DateInterval('P1D'));
9	    
10	        return $t == $yesterday;
11	    }
12	    
13	    $tk = "-----------------------------REDACTED-----------------------------";
14	    $uuid = "8f802f1b-b19d-40b5-b36c-8ae614b20fb3";
15	    $raw = file_get_contents("https://api.hypixel.net/player?uuid=".$uuid."&key=".$tk);
16	    $json = json_decode($raw);
17	    $player = $json->player;
18	    $lastClaim = ($player->lastClaimedReward)/1000;
19	    unset($tk);
20	    unset($uuid);
21	    unset($raw);
22	    unset($json);
23	    unset($player);
24	    if (isYesterday($lastClaim)) {
25	        $webhookurl = "-----------------------------REDACTED-----------------------------";
            $YourDiscordID = "-----------------------------REDACTED-----------------------------";
26	        
27	        $json_data = json_encode([
28	            "content" => "<@".$YourDiscordID."> did **NOT** do the daily reward :alarm_clock:
29	        \n\n> **PLEASE remind!!**",
30	            "username" => "Reggy's daily reward",
31	            "avatar_url" => "https://cdn.discordapp.com/attachments/748984983225499738/890272219324882976/unknown.png",
32	            "tts" => true,
33	        
34	        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
35	        
36	        $ch = curl_init( $webhookurl );
37	        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
38	        curl_setopt( $ch, CURLOPT_POST, 1);
39	        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
40	        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
41	        curl_setopt( $ch, CURLOPT_HEADER, 0);
42	        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
43	        
44	        $response = curl_exec( $ch );
45	        curl_close( $ch );
46	        
47	        echo "DO > ".$lastClaim." [".date('d/m/Y', $lastClaim)."]";
48	    } else {
49	        echo "DONE > ".$lastClaim." [".date('d/m/Y', $lastClaim)."]";
50	    }
51	?>
