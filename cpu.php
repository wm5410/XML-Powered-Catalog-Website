<?php
// Load the XML file
$xml = simplexml_load_file('data.xml');

// Filter CPU products
$cpuProducts = [];
foreach ($xml->parts->part as $part) {
    if ((string)$part['category'] === 'CPU') {
        $cpuProducts[] = $part;
    }
}

// Ways to sort 
$sortKey = isset($_GET['sort']) ? $_GET['sort'] : 'name';
usort($cpuProducts, function ($a, $b) use ($sortKey) {
    return strcmp((string)$a->$sortKey, (string)$b->$sortKey);
});

// Search bar
$searchTerm = isset($_GET['search']) ? strtolower($_GET['search']) : '';
if (!empty($searchTerm)) {
    $cpuProducts = array_filter($cpuProducts, function ($cpu) use ($searchTerm) {
        return strpos(strtolower($cpu->name), $searchTerm) !== false;
    });
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>CPU Parts</title>

<script>
    function showDetails(cpu) {
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
        imageElement.src = cpu.image;
        imageElement.alt = cpu.name;

        // Create the info container
        var infoContainer = document.createElement('div');
        infoContainer.classList.add('details-info');

        // add new details to the containers
        infoContainer.innerHTML += '<h2>' + cpu.name + '</h2>';
        infoContainer.innerHTML += '<p>' + cpu.description + '</p>';
        infoContainer.innerHTML += '<p><strong>Brand:</strong> ' + cpu.brand + '</p>';
        infoContainer.innerHTML += '<p><strong>Price:</strong> ' + cpu.price + '</p>';

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
        var filteredParts = <?php echo json_encode($cpuProducts); ?>;
        var cpu = filteredParts.find(function (part) {
            return part.image === imageName;
        });

        // Display the filtered part
        showDetails(cpu);
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
    <h1>Central Processing Unit</h1>
</header>
    <!-- Navigation bar -->
<div class="nav">
    <section class="category-link">
        <a href="index.php">Home</a>
    </section>
    <section class="category-link">
        <a href="cpu.php?sort=name">Sort by Name</a>
    </section>
    <section class="category-link">
        <a href="cpu.php?sort=price">Sort by Price</a>
    </section>
    <section class="category-link">
        <form action="cpu.php" method="get">
            <input type="text" name="search" placeholder="Search by Name">
            <button type="submit">Search</button>
        </form>
    </section>
</div>
    <!-- Displaying products on the body of the page -->
<main id="main">
    <?php
    foreach ($cpuProducts as $cpu) {
        echo '<div class="part">
            <img src="' . $cpu->image . '" alt="' . $cpu->name . '">
            <h2>' . $cpu->name . '</h2>
            <p>' . $cpu->description . '</p>
            <p><strong>Brand:</strong> ' . $cpu->brand . '</p>
            <p><strong>Price:</strong> ' . $cpu->price . '</p>
            <button onclick="filterByPart(\'' . $cpu->image . '\')">Product Details</button>
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
