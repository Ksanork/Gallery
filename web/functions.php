<?php

get_db();

function get_db()
{
    $mongo = new MongoClient(
        "mongodb://localhost:27017/",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
            'db' => 'wai',
        ]);

    $db = $mongo->wai;
	$db->images->remove();
	$db->users->remove();
	$db->favourites->remove();

    return $db;
}

function save_product($id, $product) {
    $db = get_db();

    if ($id == null) {
        $db->images->insert($product);
    } else {
        $db->images->update(['_id' => new MongoId($id)], $product);
    }
}
function save_user($id, $product) {
	$db = get_db();

    if ($id == null) {
        $db->users->insert($product);
    } else {
        $db->users->update(['_id' => new MongoId($id)], $product);
    }
}

?>
