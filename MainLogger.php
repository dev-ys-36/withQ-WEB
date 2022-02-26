<?php

use Psr\Http\Message\ServerRequestInterface;

class MainLogger{

    public const FORMAT_BOLD = "\x1b[1m";
    public const FORMAT_OBFUSCATED = "";
    public const FORMAT_ITALIC = "\x1b[3m";
    public const FORMAT_UNDERLINE = "\x1b[4m";
    public const FORMAT_STRIKETHROUGH = "\x1b[9m";

    public const FORMAT_RESET = "\x1b[m";

    public const COLOR_BLACK = "\x1b[38;5;16}m";
    public const COLOR_DARK_BLUE = "\x1b[38;5;19m";
    public const COLOR_DARK_GREEN = "\x1b[38;5;34m";
    public const COLOR_DARK_AQUA = "\x1b[38;5;37m";
    public const COLOR_DARK_RED = "\x1b[38;5;124m";
    public const COLOR_PURPLE = "\x1b[38;5;127m";
    public const COLOR_GOLD = "\x1b[38;5;214m";
    public const COLOR_GRAY = "\x1b[38;5;145m";
    public const COLOR_DARK_GRAY = "\x1b[38;5;59m";
    public const COLOR_BLUE = "\x1b[38;5;63m";
    public const COLOR_GREEN = "\x1b[38;5;83m";
    public const COLOR_AQUA = "\x1b[38;5;87m";
    public const COLOR_RED = "\x1b[38;5;203m";
    public const COLOR_LIGHT_PURPLE = "\x1b[38;5;207m";
    public const COLOR_YELLOW = "\x1b[38;5;227m";
    public const COLOR_WHITE = "\x1b[38;5;231m";
    public const COLOR_MINECOIN_GOLD = "\x1b[38;5;184m";

    public function __construct(){

    }

    public static function getTime(): string{
        return '[' . date('H:i:s') . '] ';
    }

    public static function text(string $text): void{
        $log_txt = self::getTime() . $text;

		self::logger($log_txt);

        echo $log_txt . PHP_EOL;
    }

    public static function logger(string $logger): void{
        $log_txt = $logger;
		$log_file = fopen(__DIR__ . '/log.txt', 'a');

		fwrite($log_file, $log_txt . "\r\n");
		fclose($log_file);
    }

}

?>