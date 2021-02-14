<?php
namespace App\Library;

class ApiOne implements TaskInterface
{
    public function taskList($endpoint,$parameters)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request("GET", $endpoint);
        $responseBody = json_decode($res->getBody());

        foreach ($responseBody as $key=>$item) {
            if($parameters[2]=="{key}"){
                //Adı eğer bir dizi key'i ise
                foreach ($item as $dataName=>$property) {
                    $name               = $dataName;
                    $level              = $property->{$parameters[0]};
                    $estimated_duration = $property->{$parameters[1]};
                }
            }
            else{
                //Dizi dataları alt parametre olabilme ihtimaline göre diziye alınıyor.
                foreach ($parameters as $parameter) {
                    $param[] = explode(".",$parameter);
                }

                //Alt dataları olması yada ana dizide tutulma durumuna göre değişkene alınıyor
                if(count($param[0])>1)
                    $level = $item->{$param[0][0]}->{$param[0][1]};
                else
                    $level = $item->{$param[0][0]};

                if(count($param[1])>1)
                    $estimated_duration = $item->{$param[1][0]}->{$param[1][1]};
                else
                    $estimated_duration = $item->{$param[1][0]};

                if(count($param[2])>1)
                    $name = $item->{$param[2][0]}->{$param[2][1]};
                else
                    $name = $item->{$param[2][0]};

            }

            //Data oluşturuluyor
            $task = new \stdClass();
            $task->name                 = $name;
            $task->level                = $level;
            $task->estimated_duration   = $estimated_duration;
            $newData[] = $task;
        }
        return $newData;
    }

}
