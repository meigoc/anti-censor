<?php
namespace meigo\modules;

use std, gui, framework, meigo;


class AppModule extends AbstractModule
{

    /**
     * @event construct 
     */
    function doConstruct(ScriptEvent $e = null)
    {    
        echo "[INFO] Application Started\n";
        echo "▄▀█ █▄░█ ▀█▀ █ ▄▄ █▀▀ █▀▀ █▄░█ █▀ █▀█ █▀█   ▄█ ░ █▀█\n";
        echo "█▀█ █░▀█ ░█░ █ ░░ █▄▄ ██▄ █░▀█ ▄█ █▄█ █▀▄   ░█ ▄ █▄█\n";
        echo "Anti-Censor v1.0 | Build 04192349_24 | Developed by Meigo\n";
        
        $upd = trim(file_get_contents("https://raw.githubusercontent.com/meigoc/anti-censor/main/update_system/latest"));
        if ($upd != "1.0"){
            echo "==============================================\nA new update has been found! Download it from our github.\n==============================================\n";
        }
        
        echo "* Github: @meigoc\n";
        echo "* Discord: @glebbb\n";
        echo "* Repository: github.com/meigoc/anti-censor\n\n";
        echo "Menu: (Commands)\n\n";
        echo "& anticensor (letter-change/font-change) {text}\n";
        echo "   Letter-change: This type of anti-censorship changes Russian letters to similar English counterparts (badly bypasses censorship)\n";
        echo "   Font-change: This type of anti-censorship changes the font of Russian letters (perfectly bypasses censorship)\n";
        echo "& license\n";
        echo "& exit\n";
        
        echo "❤️ Support us, we work for free!\nPayPal: temp. not support\nDonationAlerts: https://www.donationalerts.com/r/meigostudios\n";
        
        $misc = new MiscStream('stdin');
        $misc->eachLine(function($line){
            $cmd = str::split($line, ' ');
            $method = 'cmd' . $cmd[0];
            
            if (method_exists($this, $method)){ // Если метод существует
                unset($cmd[0]);
                echo call_user_func_array([$this, $method], $cmd);
            } else { // неизвестная команда
                echo "Unsupported command";
            }
            
            echo "\n";
        }); 
    }
    
    // Anti-Censor Commands
    
    /**
     * Command: Now 
     */
    function cmdanticensor(...$args){
        switch ($args[0]){
            case 'letter-change': // анти-цензура путем подменой похожих букв
                $text = str::join($args, ' ');
                $zamena = array("letter-change", "К", "е", "Е", "Н", "х", "Х", "В", "а", "А", "р", "Р", "о", "О", "с", "С", "М");
                $naeto   = array("", "K", "e", "E", "H", "x", "X", "B", "a", "A", "p", "P", "o", "O", "c", "C", "M");
                $a = str_replace($zamena, $naeto, $text);
                
                // "Подсветка" изменённых символов. Пока-что в разработке...
                $search = 'K';
                $pos = str::posIgnoreCase($a, $search);
                if ($pos != "-1"){
                    $repeat = str::repeat(" ", $pos);
                }
                // --- end ---
                
                // Выводим:
                echo $a."\n";
                echo $repeat."~"; // "Подсветка" изменённых символов. Пока-что в разработке...
                //return $a; * не нужно.
            break;
            
            case 'font-change': // анти-цензура путем изменения шрифта
                $text = str::join($args, ' ');
                $zamena = array("font-change", "у", "к", "е", "н", "ф", "в", "а", "р", "о", "с");
                $naeto   = array("", "ʏ", "ᴋ", "ᴇ", "ʜ", "ȹ", "ʙ", "ᴀ", "ᴘ", "ᴏ", "ᴄ");
                $a = str_replace($zamena, $naeto, $text);
                
                // "Подсветка" изменённых символов. Пока-что в разработке...
                $search = 'ȹ';
                $pos = str::posIgnoreCase($a, $search);
                if ($pos != "-1"){
                    $repeat = str::repeat(" ", $pos);
                }
                // --- end ---
                
                // Выводим:
                echo $a."\n";
                echo $repeat."~"; // "Подсветка" изменённых символов. Пока-что в разработке...
                //return $a; * не нужно.
            break;
                
        }
    } 
    // Experimental commands
    
    function cmdlicense(){
        // license
        echo "█░░ █ █▀▀ █▀▀ █▄░█ █▀ █▀▀\n";
        echo "█▄▄ █ █▄▄ ██▄ █░▀█ ▄█ ██▄\n";
        echo "License @ GNU GENERAL PUBLIC LICENSE v3.0\n";
        echo "============================================\n";
        $a = file_get_contents("https://raw.githubusercontent.com/meigoc/anti-censor/main/LICENSE");
        echo $a."\n";
        echo "============================================\n";
    }
    
    // Basic commands (for developer)
    
    /**
     * Command: Now 
     */
    function cmdNow(){
        return Time::Now()->getTime();
    } 
    
    /**
     * Command: Base64
     */
    function cmdbase64(...$args){
        switch ($args[0]){
            case 'encode':
                return base64_encode($args[1]);
            break;
            
            case 'decode':
                return base64_decode($args[1]);
            break;
                
        }
    } 
    
    /**
     * Command: Exit
     */
    function cmdExit(){
        echo "Exiting...\nIf the exit fails, use the keyboard shortcut CTRL+C\n";
        exit;
    } 

}
