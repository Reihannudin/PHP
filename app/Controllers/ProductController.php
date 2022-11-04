<?php

namespace Reedb\PhpMvc\Controllers;

class ProductController{
    function categories(string $productId , string $categoryId) : void{
        echo "Product $productId, Category $categoryId";
    }
}