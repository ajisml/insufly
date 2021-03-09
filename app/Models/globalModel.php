<?php namespace App\Models;

    use CodeIgniter\Model;

    class globalModel extends Model{
        public function getLog($username=null, $id=null)
        {
            if($username !== null){
                return $this->db->table('users')->where(['username'=>$username])->get()->getRowArray();
            }elseif($id !== null){
                return $this->db->table('users')->where(['id'=>$id])->get()->getRowArray();
            }
        }
        public function addTrx($data)
        {
            return $this->db->table('trx')->insert($data);
        }
        public function deleteInv($id)
        {
            return $this->db->table('invoice')->delete(['id'=>$id]);
        }
        public function deleteTrx($code)
        {
            return $this->db->table('trx')->delete(['code_invoice'=>$code]);
        }
        public function getInvoice($code = null)
        {
            if($code !== null){
                return $this->db->table('invoice')->where(['code_invoice'=>$code])->get()->getRowArray();
            }else{
                return $this->db->table('invoice')->get()->getResultArray();
            }
        }
        public function getTrx($id = null, $what = null)
        {
            if($id !== null AND $what === "id"){
                return $this->db->table('trx')->where(['id'=>$id])->get()->getRowArray();
            }elseif ($id !== null AND $what === "code_invoice") {   
                return $this->db->table('trx')->select('trx.name_buyer,trx.qty,trx.code_invoice, product.name as name_product, product_variant.price as price_product,trx.disc , category.name as category, variant.name as variant, sub_variant.name as sub_variant')
                ->join('product_variant','product_variant.id=trx.product_variant_id')
                ->join('product','product.id=product_variant.product_id')
                ->join('category','category.id=product.category_id')
                ->join('variant','variant.id=trx.variant_id')
                ->join('sub_variant','sub_variant.id=product_variant.sub_variant_id')
                ->where(['code_invoice'=>$id])->get()->getResultArray();
            }else{
                return $this->db->table('trx')->get()->getResultArray();
            }
        }
        public function addInv($data)
        {
            $this->db->table('invoice')->insert($data);
            return $this->insertID();
        }
        public function getInv($id = null)
        {
            if($id !== null){
                return $this->db->table('invoice')->where(['id'=>$id])->get()->getRowArray();
            }else{
                return $this->db->table('invoice')->select('invoice.id as invoice_id, invoice.code_invoice, invoice.note, invoice.date_at,pelanggan.id as pelanggan_id, pelanggan.name_full')->join('pelanggan','pelanggan.id=invoice.pelanggan_id')->orderBy('invoice.id','DESC')->get()->getResultArray();
            }
        }
        // Cart
        public function deleteCart($id)
        {
            return $this->db->table('cart')->delete(['id'=>$id]);
        }
        public function getCart($id)
        {
            return $this->db->table('cart')->select('cart.product_variant_id,product_variant.product_id, product_variant.sub_variant_id, product.name as name_product, product_variant.price, sub_variant.name as name_sub_variant, cart.id as cart_id')->join('product_variant','product_variant.id=cart.product_variant_id')->join('product','product.id=product_variant.product_id')->join('sub_variant','sub_variant.id=product_variant.sub_variant_id')->where(['cart.users_id'=>$id])->get()->getResultArray();
        }
        public function insertUpdateCart($data, $id=null)
        {
            if($id !== null){
                return $this->db->table('cart')->update($data, ['id'=>$id]);
            }else{
                return $this->db->table('cart')->insert($data);
            }
        }
        // Buyyer
        public function deleteBuyyer($id)
        {
            return $this->db->table('pelanggan')->delete(['id'=>$id]);
        }
        public function getBuyyer($id = null)
        {
            if($id !== null){
                return $this->db->table('pelanggan')->where(['id'=>$id])->get()->getRowArray();
            }else{
                return $this->db->table('pelanggan')->get()->getResultArray();
            }
        }
        public function CreateUpdateBuyer($data, $id=null)
        {
            if($id !== null){
                return $this->db->table('pelanggan')->update($data, ['id'=>$id]);
            }else{
                return $this->db->table('pelanggan')->insert($data);
            }
        }
        // Variant
        public function getProductVariant($id)
        {
            return $this->db->table('product_variant')->select('product_variant.product_id,product_variant.id as idpv, product_variant.price, product.name as name_product, sub_variant.name as name_subvar')->join('product','product.id=product_variant.product_id')->join('sub_variant','sub_variant.id=product_variant.sub_variant_id')->where(['id'=>$id])->get()->getRowArray();
        }
        public function updateProductVariant($data, $id)
        {
            return $this->db->table('product_variant')->update($data, ['id'=>$id]);
        }
        public function getIdProductVariant($id)
        {
            return $this->db->table('product_variant')->where(['product_id'=>$id])->get()->getResultArray();
        }
        public function getIdProductVariantJoin($id)
        {
            return $this->db->table('product_variant')->select('product_variant.id as idvar, product_variant.sub_variant_id, product_variant.price, sub_variant.name')
            ->join('sub_variant','sub_variant.id=product_variant.sub_variant_id')->where(['product_variant.product_id'=>$id])->get()->getResultArray();
        }
        public function insertProductVariant($data)
        {
            return $this->db->table('product_variant')->insert($data);
        }
        public function deleteProductVariant($id)
        {
            return $this->db->table('product_variant')->delete(['product_id'=>$id]);
        }
        public function saveSubvar($data)
        {
            return $this->db->table('sub_variant')->insert($data);
        }
        public function deleteVariant($id)
        {
            return $this->db->table('variant')->delete(['id'=>$id]);
        }
        public function deleteSubVariant($id)
        {
            return $this->db->table('sub_variant')->delete(['id'=>$id]);
        }
        public function editVariant($data, $id)
        {
            return $this->db->table('variant')->update($data, ['id'=>$id]);
        }
        public function editSubVariant($data, $id)
        {
            return $this->db->table('sub_variant')->update($data, ['id'=>$id]);
        }
        public function addVariant($data)
        {
            return $this->db->table('variant')->insert($data);
        }
        public function getVar($id=null,$type)
        {
            if($id !== null AND $type === "subvariant"){
                return $this->db->table('sub_variant')->where(['id'=>$id])->get()->getRowArray();
            }elseif($id === null AND $type === "subvariant"){
                return $this->db->table('sub_variant')->get()->getResultArray();
            }elseif ($id !== null AND $type === "variant") {
                return $this->db->table('variant')->where(['id'=>$id])->get()->getRowArray();
            }elseif ($id === null AND $type === "variant") {
                return $this->db->table('variant')->get()->getResultArray();
            }
        }
        // Product
        public function getProduct($id=null)
        {
            if($id !== null){
                return $this->db->table('product')->where(['id'=>$id])->get()->getRowArray();
            }else{
                return $this->db->table('product')->get()->getResultArray();
            }
        }
        public function createUpdateProduct($data, $id=null)
        {
            if($id !== null){
                return $this->db->table('product')->update($data, ['id'=>$id]);
            }else{
                $this->db->table('product')->insert($data);
                return $this->db->insertID();
            }
        }
        public function deleteProduct($id)
        {
            return $this->db->table('product')->delete(['id'=>$id]);
        }
        // Category
        public function deleteCat($id)
        {
            return $this->db->table('category')->delete(['id'=>$id]);
        }
        public function getCat($id=null)
        {
            if($id !== null){
                return $this->db->table('category')->where(['id'=>$id])->get()->getRowArray();
            }else{
                return $this->db->table('category')->get()->getResultArray();
            }
        }
        public function CreateUpdateCat($data, $id=null)
        {
            if($id !== null){
                return $this->db->table('category')->update($data, ['id'=>$id]);
            }else{
                return $this->db->table('category')->insert($data);
            }
        }
    }