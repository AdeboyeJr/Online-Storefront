<?php
// connect to database
$mysqli = mysqli_connect("localhost", "u667897109_Ade", "T#st1125", "u667897109_Data");

$display_block = "<h1 id=\"banner\">My Categories</h1>
<h2 id=\"banner\">Scroll through the items in each category.</h2><main id=\"content\">";



// show categories first
$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";

$get_cats_res = mysqli_query($mysqli, $get_cats_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_cats_res) < 1) {
    $display_block = "<p><em>Sorry, no categories to browse.</em></p>";

} else {
    while ($cats = mysqli_fetch_array($get_cats_res)) {
        $cat_id = $cats['id'];
        $cat_title = strtoupper(stripslashes($cats['cat_title']));
        $cat_desc = stripslashes($cats['cat_desc']);

      
        $display_block .= "<h2 class=\"cat-title\">".$cat_title."</h2>\n<p class=\"cat-desc\">".$cat_desc."</p>";

        // get items
        $get_items_sql = "SELECT id, item_title, item_price, item_desc, item_image FROM store_items WHERE cat_id = '".$cat_id."' ORDER BY item_title";

        $get_items_res = mysqli_query($mysqli, $get_items_sql) or die(mysqli_error($mysqli));

        if (mysqli_num_rows($get_items_res) < 1) {
            $display_block = "<p><em>Sorry, no items in this category.</em></p>";
        } else {
            $display_block .= "<section class=\"liquid-slider\" id=\"main-slider-".$cat_id."\">";

            while ($items = mysqli_fetch_array($get_items_res)) {
                $item_id = $items['id'];
                $item_title = stripslashes($items['item_title']);
                $item_img = $items['item_image'];
                $item_price = $items['item_price'];
                $item_desc = $items['item_desc'];

                $display_block .= <<<END_OF_TEXT
                <div>
                <h2 class="title">$item_title</h2>
                <p>
                <img src="images/$item_img" alt="$item_title">
                $item_desc
                </p>
                <p>Price: \$$item_price</p>
                <p><a href="seestore.php?cat_id=$cat_id"><button id="buy-now">Buy Now</button></a></p>
                </div>
                END_OF_TEXT;
            }


            $display_block .= <<<END_OF_TEXT

            </section>
            </main>
            <script type="text/javascript">
            $(function() {
                $('#main-slider-$cat_id').liquidSlider({
                    dynamicTabs: false,
                    hoverArrows: false
                });

            });
            </script>
            END_OF_TEXT;
        }

    
        // free results
        mysqli_free_result($get_items_res);
    

    }
}
// free results
mysqli_free_result($get_cats_res);

// close connection to MySQL
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Categories</title>
    <link rel="icon" href="images/devtools.png" type="image/x-icon">
    <link rel="stylesheet" href="node_modules/liquidslider/css/liquid-slider.css">
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/store.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.18/jquery.touchSwipe.min.js"></script>
    <script src="node_modules/liquidslider/js/jquery.liquid-slider.min.js"></script>
</head>
<body>
    
    <?php echo $display_block; ?>

    <a href="/"><button id="home">Home</button></a>
</body>
</html>