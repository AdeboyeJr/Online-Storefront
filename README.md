# Online Storefront

## Author: Adeboye Adegbenro Jr.

#### Description

A simple Online Storefront. Users can view catalogs of books, hats, clothes, games and more. Listings include a short description, price, colors and sizes.

#### Implementation

The web application begins with the `seestore.php` page. This is the catalog for the web app that makes MySQL queries to extract data on the different categories and store items. The first query is for showing all the categories available on the site.

```php
$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";
```

Within each category are the list of items that include a link to their respective pages. The script embeds a hyperlink to itself and embeds the category id as a GET request parameter. Selecting a category loads the category id in the URL. A bullet list displays the items in available in the selected category. Upon clicking the item, the user is directed to the `showitem.php` page. This script queries the database for details on the selected item, which includes the name, description, price, and image.

```php
$get_item_sql = "SELECT c.id as cat_id, c.cat_title, si.item_title, si.item_price, si.item_desc, si.item_image FROM store_items AS si LEFT JOIN store_categories AS c
ON c.id = si.cat_id WHERE si.id = '".$safe_item_id."'";
```

The `seestore_withJS.php` script is identical to `seestore.php` except that it includes premade CSS styling scripts and JavaScript code. This script creates a liquid slider to preview items in each catelog. The script also uses JQuery to select a category by its id and change its presentation.

#### Dependencies

You need a web browser that supports JavaScript.
