<?php
    // get categories from the database
    $categories = get_categories();
    
    // get all colleges form the database
    $colleges = get_colleges();
    
    $search_head; // variable to store the heading for the search result

    // check if category is specified or not 
    if (empty($_GET["category"]) && empty($_GET["college"]) && empty($_GET["seller"])  && empty($_GET["q"]))
    {
        // get recent addtions of all categories
        $products = get_recent_products();
        $search_head = "Recent Additions";
    }
    else if (empty($_GET["college"]) && empty($_GET["seller"]) && empty($_GET["q"]))
    {
        // get recent additions of the given category
        $products = get_products_by(1, $_GET["category"]);
        $search_head = "Category: ".$products[0]["category"];
    }
    else if (empty($_GET["seller"]) && empty($_GET["q"]))
    {
        // get recent additons of the given college
        $products = get_products_by(2, $_GET["college"]);
        $search_head = "College: ".$products[0]["college"];
    }
    else if (empty($_GET["q"]))
    {
        // get recent products from the given user
        $products = get_products_by(3, $_GET["seller"]);
        $search_head = "Search by seller";
    }
    else
    {
	// get products based on search keywords
	$products = search_products($_GET["q"]);
	$search_head = "Search: ".htmlspecialchars($_GET["q"]);        
    }

    // render store view
    render("store_view", ["title" => "Store", "categories" => $categories, "colleges" => $colleges, "search_head" => $search_head, "products" => $products]);
?>
