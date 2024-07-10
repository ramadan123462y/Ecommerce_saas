<?php
namespace App\Services\Cart;


interface CartInterface
{

    public function cart();

    public function updateorcreate($request, $id_product);

    public function update_quintity($id, $quenty);

    public function  product_details($product_id);
}
