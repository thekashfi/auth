<?php


namespace Models;


use Database\DB;

class Contact
{
    public function of($user_id)
    {
        $sql = "SELECT * FROM contacts WHERE user_id = ? ORDER BY updated_at DESC LIMIT 10";
        $pdo = DB::pdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function imagePath($image)
    {
        return asset("/images/{$image}");
    }
}