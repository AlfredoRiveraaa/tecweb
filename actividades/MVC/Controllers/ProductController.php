<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/../Models/Products.php';

    class ProductController{
        public function add($producto){
            $prodObj = new Products();
            $prodObj->add($producto);
            echo $prodObj->getData();
            unset($prodObj);
        }

        public function delete($id){
            $prodObj = new Products();
            $prodObj->delete($id);
            echo $prodObj->getData();
            unset($prodObj);
        }

        public function edit($producto){
            $prodObj = new Products();
            $prodObj->edit($producto);
            echo $prodObj->getData();
            unset($prodObj);
        }

        public function get($id){
            $prodObj = new Products();
            $prodObj->get($id);
            echo $prodObj->getData();
            unset($prodObj);
        }

        public function list(){
            $prodObj = new Products();
            $prodObj->list();
            echo $prodObj->getData();
            unset($prodObj);
        }

        public function search($search){
            $prodObj = new Products();
            $prodObj->search($search);
            echo $prodObj->getData();
            unset($prodObj);
        }
    }
?>