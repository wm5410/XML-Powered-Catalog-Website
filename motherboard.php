<?php
// Load the XML file
$xml = simplexml_load_file('data.xml');

// Filter Motherboard products
$motherboardProducts = [];
foreach ($xml->parts->part as $part) {
    if ((string)$part['category'] === 'Motherboard') {
        $motherboardProducts[] = $part;
    }
}

// Ways to sort 
$sortKey = isset($_GET['sort']) ? $_GET['sort'] : 'name';
usort($motherboardProducts, function ($a, $b) use ($sortKey) {
    return strcmp((string)$a->$sortKey, (string)$b->$sortKey);
});

// Search bar
$searchTerm = isset($_GET['search']) ? strtolower($_GET['search']) : '';
if (!empty($searchTerm)) {
    $motherboardProducts = array_filter($motherboardProducts, function ($motherboard) use ($searchTerm) {
        return strpos(strtolower($motherboard->name), $searchTerm) !== false;
    });
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Motherboard Parts</title>

    <script>
        function showDetails(motherboard) {
            // Code to hide other products and show only the selected part
            document.getElementById('main').style.display = 'none';
            document.getElementById('details').innerHTML = '';

            // Create the details container
            var detailsDiv = document.getElementById('details');
            var detailsContainer = document.createElement('div');
            detailsContainer.classList.add('details-container');

            // Create the image element
            var imageElement = document.createElement('img');
            imageElement.classList.add('details-image');
            imageElement.src = motherboard.image;
            imageElement.alt = motherboard.name;

            // Create the info container
            var infoContainer = document.createElement('div');
            infoContainer.classList.add('details-info');

            // add new details to the containers
            infoContainer.innerHTML += '<h2>' + motherboard.name + '</h2>';
            infoContainer.innerHTML += '<p>' + motherboard.description + '</p>';
            infoContainer.innerHTML += '<p><strong>Brand:</strong> ' + motherboard.brand + '</p>';
            infoContainer.innerHTML += '<p><strong>Price:</strong> ' + motherboard.price + '</p>';

            // Create the Back button
            var backButton = document.createElement('button');
            backButton.textContent = 'Back';
            backButton.addEventListener('click', goBack);

            // add everything to the details container
            infoContainer.appendChild(backButton);
            detailsContainer.appendChild(imageElement);
            detailsContainer.appendChild(infoContainer);

            // add the details container to the main container
            detailsDiv.appendChild(detailsContainer);
        }

        function filterByPart(imageName) {
            var filteredParts = <?php echo json_encode($motherboardProducts); ?>;
            var motherboard = filteredParts.find(function (part) {
                return part.image === imageName;
            });

            // Display the filtered part
            showDetails(motherboard);
        }

        //Funcionality for filtering
        function goBack() {
            document.getElementById('main').style.display = 'flex';
            document.getElementById('details').innerHTML = '';
        }
    </script>
</head>
<body>

<header>
    <h1>Motherboard Parts</h1>
</header>
    <!-- Navigation bar -->
<div class="nav">
    <section class="category-link">
        <a href="index.php">Home</a>
    </section>
    <section class="category-link">
        <a href="motherboard.php?sort=name">Sort by Name</a>
    </section>
    <section class="category-link">
        <a href="motherboard.php?sort=price">Sort by Price</a>
    </section>
    <section class="category-link">
        <form action="motherboard.php" method="get">
            <input type="text" name="search" placeholder="Search by Name">
            <button type="submit">Search</button>
        </form>
    </section>
</div>

    <!-- Displaying products on the body of the page -->
<main id="main">
    <?php
    foreach ($motherboardProducts as $motherboard) {
        echo '<div class="part">
            <img src="' . $motherboard->image . '" alt="' . $motherboard->name . '">
            <h2>' . $motherboard->name . '</h2>
            <p>' . $motherboard->description . '</p>
            <p><strong>Brand:</strong> ' . $motherboard->brand . '</p>
            <p><strong>Price:</strong> ' . $motherboard->price . '</p>
            <button onclick="filterByPart(\'' . $motherboard->image . '\')">Product Details</button>
        </div>';
    }
    ?>
</main>

    <!-- Div for single item -->
<div id="details"></div>
    
    <!-- Footer -->
<div class="site-footer">
    <div class="footer-content">
        <p>&copy; 2023 ByteBlitz. All rights reserved.</p>
    </div>
</div>

</body>
</html>
