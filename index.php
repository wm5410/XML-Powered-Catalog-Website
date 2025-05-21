<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php
    // Load XML file
    $xml = simplexml_load_file('data.xml');
    
    // Extract data from XML
    $title = $xml->title;
    $cpu = $xml->xpath('//part[@category="CPU"][1]')[0];
    $motherboard = $xml->xpath('//part[@category="Motherboard"][1]')[0];
    $gpu = $xml->xpath('//part[@category="GPU"][1]')[0];
    $other = $xml->xpath('//part[@category="Other"][1]')[0];
    ?>
    <title>Home</title>
</head>
<body>
    <header>
        <h1><?php echo $title; ?></h1>
    </header>
    <!-- Navigation bar -->
    <div class="nav">
        <section class="category-link">
            <a href="index.php">Home</a>
        </section>
        <section class="category-link">
            <a href="cpu.php?category=CPU">CPU</a>
        </section>
        <section class="category-link">
            <a href="motherboard.php?category=Motherboard">Motherboard</a>
        </section>
        <section class="category-link">
            <a href="gpu.php?category=GPU">GPU</a>
        </section>
        <section class="category-link">
            <a href="other.php?category=Other">Other</a>
        </section>
    </div>
    
    <br>
    <br>
    <h2>Most Popular Items</h2>
    <br>
    <br>
    <!-- Displaying products on the body of the page -->
    <main>
        <?php
        //Only display one of each part
        function displayPart($part) {
            echo "<section class='part'>";
            echo "<h2>{$part->name}</h2>";
            echo "<img src='{$part->image}' alt='{$part->name} Image'>";
            echo "<p>{$part->description}</p>";
            echo "<p>Brand: {$part->brand}</p>";
            echo "<p>Price: {$part->price}</p>";
            echo "</section>";
        }

        displayPart($cpu);
        displayPart($motherboard);
        displayPart($gpu);
        displayPart($other);
        ?>
    </main>
    
        <!-- Footer -->
    <div class="site-footer">
        <div class="footer-content">
            <p>&copy; 2023 ByteBlitz. All rights reserved.</p>
        </div>
    </div>

    
</body>
</html>
