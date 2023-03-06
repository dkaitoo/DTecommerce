<?php
namespace App\Http\Controllers;

use App\Models\Ontology;
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotManController extends Controller
{

    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function($bot, $message) {
            $bot->typesAndWaits(2);
            $message1 = Ontology::where('ask',[strtolower($message)])->first();
            if(strtolower($message) == 'xin chào' || strtolower($message) == 'hi' || strtolower($message) == 'hello' || strtolower($message) == 'chào'){
                $bot->reply('Xin chào bạn. Bạn cần giúp gì ạ?');
            }
            elseif ($message1) {
//                dd($answer);
                $reply = json_decode($message1->answer);
                $bot->reply($reply[0]);
                $bot->typesAndWaits(2);
                $bot->reply('Bạn có thắc mắc gì nữa không ạ?');
//                $bot->ask('Bạn có thắc mắc gì nữa không?', function() {
//                    $this->listen();
//                });
            }
            elseif($message == 'Cảm ơn' || $message == 'Không'){
                $bot->reply('Rất vui khi được giúp đỡ bạn.');
            }
            else{
                $bot->reply("Rất tiếc. Tôi không hiểu yêu cầu của quý khách. Hãy nhập một số câu như gợi ý đã cung cấp.");
            }

        });

        $botman->listen();
    }
}
