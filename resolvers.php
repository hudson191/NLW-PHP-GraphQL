<?php

use Overblog\DataLoader\DataLoader;

return [
    'Points' =>[
        'image_url' => function($root,$args,$context){
            return $root['image'];
        },
        'items' => function($root,$args,$context){
            $db = new Sqlite3('db.sqlite');
            $res = $db->query('select * from items
            inner join point_items on items.id = point_items.item_id
            where point_items.point_id = ' . $root['id']);
            $ret = array();
            while ($row = $res->fetchArray()) {
                $ret[] = $row;
            }
            return $ret;
        }
    ],
    'Mutation' => [
        'novoPoint' => function($root,$args,$context){
            $db = new Sqlite3('db.sqlite');

            $ins = "insert into points (    
                name,image,email,whatsapp,longitude,latitude,city,uf
                ) values (";
            $ins .= "'".$args['name']."',";
            $ins .= "'".$args['image_url']."',";
            $ins .= "'".$args['email']."',";
            $ins .= "'".$args['whatsapp']."',";
            $ins .= "'".$args['longitude']."',";
            $ins .= "'".$args['latitude']."',";
            $ins .= "'".$args['city']."',";
            $ins .= "'".$args['uf']."')";

            $db->exec($ins);

            $pointId = $db->lastInsertRowID();

            if(isset($args['items'])){
                foreach($args['items'] as $val){
                    $ins = "insert into point_items ( point_id,item_id ) values (";
                    $ins .= "'" . $pointId ."',";
                    $ins .= "'" . $val . "')";
                    $db->exec($ins);
                }
            }
            $args['id'] = $pointId;
            return $args;
        }
    ],
    'Query' => [
        'items' => function($root, $args, $context) {
            $db = new Sqlite3('db.sqlite');
            $res = $db->query('select * from items');
            $ret = array();
            while ($row = $res->fetchArray()) {
                $ret[] = $row;
            }
            return $ret;
        },
        'points' => function($root, $args, $context){
            $db = new Sqlite3('db.sqlite');
            $res = $db->query('select * from points');
            $ret = array();
            while ($row = $res->fetchArray()) {
                $ret[] = $row;
            }
            return $ret;
        }
    ]
];
