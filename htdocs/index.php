<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333333;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
            color: #555555;
        }
        input[type="radio"], input[type="number"] {
            margin: 10px 0;
        }
        button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #dddddd;
            border-radius: 5px;
        }
        .result h2 {
            color: #333333;
        }
        .result p {
            margin: 5px 0;
            color: #555555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Customer Order</h1>
        <form method="POST" action="">
            <label for="item">Select Item:</label><br>
            <input type="radio" name="item" value="French Fries" required> French Fries  ($1.00)<br>
            <input type="radio" name="item" value="Burger"> Burger ($0.50)<br>
            <input type="radio" name="item" value="Spaghetti"> Spaghetti ($0.75)<br>
            <input type="radio" name="item" value="Carbonara"> Carbonara ($2.00)<br>
            <input type="radio" name="item" value="Chicken Nuggets"> Chicken Nuggets ($1.50)<br><br>

            <label for="quantity">Quantity:</label> <br>
            <input type="number" name="quantity" min="1" required><br><br>

            <label for="dine_option">Dine In or Take Out:</label><br>
            <input type="radio" name="dine_option" value="Dine In" required> Dine In<br>
            <input type="radio" name="dine_option" value="Take Out"> Take Out<br><br>

            <button type="submit" name="submit">Calculate</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            // Function to check the selected radio button
            function getSelectedItem($item) {
                return htmlspecialchars($item);
            }

            // Function to get the price of the selected item
            function getPrice($item) {
                $prices = [
                    "French Fries" => 1.00,
                    "Burger" => 0.50,
                    "Spaghetti" => 0.75,
                    "Carbonara" => 2.00,
                    "Chicken Nuggets" => 1.50
                ];
                return $prices[$item] ?? 0;
            }

            // Function to calculate tax
            function calculateTax($amount, $dineOption) {
                if ($dineOption === "Take Out") {
                    return $amount * 0.12;
                }
                return 0;
            }

            // Function to calculate total amount
            function calculateTotal($price, $quantity, $tax) {
                return ($price * $quantity) + $tax;
            }

            // Get form inputs
            $item = getSelectedItem($_POST['item']);
            $quantity = (int)$_POST['quantity'];
            $dineOption = htmlspecialchars($_POST['dine_option']);

            // Calculate price, tax, and total
            $price = getPrice($item);
            $subtotal = $price * $quantity;
            $tax = calculateTax($subtotal, $dineOption);
            $total = calculateTotal($price, $quantity, $tax);

            // Display results
            echo "<div class='result'>";
            echo "<h2>Order Summary</h2>";
            echo "<p><strong>Item:</strong> $item</p>";
            echo "<p><strong>Quantity:</strong> $quantity</p>";
            echo "<p><strong>Dine Option:</strong> $dineOption</p>";
            echo "<p><strong>Subtotal:</strong> $" . number_format($subtotal, 2) . "</p>";
            echo "<p><strong>Tax:</strong> $" . number_format($tax, 2) . "</p>";
            echo "<p><strong>Total Amount Due:</strong> $" . number_format($total, 2) . "</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>