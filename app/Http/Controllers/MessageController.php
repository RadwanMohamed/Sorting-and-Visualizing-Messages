<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getMessages();
        return view('welcome',['data'=>$data]);

    }
    private function getMessages()
    {
        $messages =[];
        $data =$this->makeExternalRequest(self::MESSAGES_API);
        foreach ($data['feed']['entry'] as $key => $value)
        {
            $returnArray = [];
            $pattern = "/(messageid|message|sentiment):(.+?)(?= messageid:| message:| sentiment:|$)/";
            preg_match_all($pattern ,$value['content']['$t'],$m ,PREG_SET_ORDER);
            foreach($m as $item)
            {
                $returnArray[$item[1]] = trim(rtrim($item[2],','));
                $returnArray['location'] = $this->getMessageLocation($value['content']['$t']);
                $returnArray['icon'] = self::getIcon(trim($m[2][2]));
                $returnArray['color'] = self::getTextColor(trim($m[2][2]));
            }
            $messages[] =$returnArray;
        }
        return $messages;
    }


    private function getMessageLocation($message)
    {
        $url =sprintf(self::GOOGLE_API,urlencode($message),env('GOOGLE_API_KEY'));
        $data = $this->makeExternalRequest($url);
        if ($data['status'] == 'OK')
        {
            return $data['results'][0]['geometry']['location'];
        }
        else{
            return [];
        }
    }


}
