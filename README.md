# XML-Powered Catalog Website

## Overview

This project is a PHP-driven dynamic catalog website. All item data is stored in a single `catalog.xml` file. The site allows users to:

- View a summary list of catalog items  
- Sort items by multiple fields (e.g., name, year, price)  
- Search items by keyword  
- Click an item to view its detailed page  

The topic of this catalog is **computer parts and accessories**, but you can adapt it to any subject with at least 20 items.

## Requirements

- PHP for server-side XML parsing and page generation  
- Hand-written HTML, CSS, JavaScript (no generators)  
- Self-contained folder structure with relative paths  
- All catalog data in `catalog.xml`  
- Separate `images/` directory containing item images referenced by XML  

## Structure

```
/ (root)
│   index.php            ← Home page / summary list  
│   item.php             ← Detail page for a single item  
│   catalog.xml          ← XML data source  
│   style.css            ← Shared stylesheet  
│   script.js            ← Client-side enhancements  
└───images/
    │   part1.jpg
    │   part2.jpg
    │   ...             ← One image per catalog item
```

## Features

1. **Data Source**  
   - `catalog.xml` contains `<item>` entries, each with at least five fields and an `image` path.  

2. **Summary Listing (`index.php`)**  
   - Loads and parses `catalog.xml` using PHP's `simplexml_load_file()`  
   - Displays items in a grid/list with thumbnail, title, and short description  
   - Sorting links (e.g., by `title`, `year`, `price`) trigger different query parameters  
   - Search form filters items by matching keywords in title or description  

3. **Detail View (`item.php`)**  
   - Receives an `id` parameter (e.g., index or unique key)  
   - Looks up the corresponding `<item>` in `catalog.xml`  
   - Renders full item details and full-size image  

4. **Client-Side Enhancements**  
   - Optional JavaScript for interactive behaviors (e.g., dynamic filtering without reload)  

## Usage

1. Place the project folder on a PHP‑enabled web server.  
2. Navigate to `http://<server>/index.php`.  
3. Use sorting links or search bar to refine the list.  
4. Click an item’s “Details” button to view its full page (`item.php?id=<n>`).

## Screenshots 

Home page
![GET example](pic2.png?raw=true "Home page")

GPU Page
![GET example](pic1.png?raw=true "Home page")
