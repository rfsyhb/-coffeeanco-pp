<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="wrapper">
            <div class="left">
                <img src="assets/images/daridatabase" alt="">
            </div>
            <div class="right">
                <h2>The Pink Mandarin</h2>
                <h4>A refreshing blend of Arabica with hints of citrus.</h4>
                <h4>IDR 58.499</h4>
                <form action="product_detail.php">
                    <label for="quantity">QUANTITY</label>
                    <div class="quantity-input">
                        <button type="button" onclick="decrementValue()">-</button>
                        <input type="text" id="quantity" name="quantity" value="1" readonly>
                        <button type="button" onclick="incrementValue()">+</button>
                    </div>
                    <button type="submit" class="btn">ADD TO CART</button>
                </form>
                <div class="upselling-lists">
                    <div class="upselling-item">
                        <div class="upselling-image"></div>
                        <p class="upselling-name">Sample</p>
                        <p class="upselling-price">IDR 56.999</p>
                    </div>
                    <div class="upselling-item">
                        <div class="upselling-image"></div>
                        <p class="upselling-name">Sample</p>
                        <p class="upselling-price">IDR 56.999</p>
                    </div>
                    <!-- pakai PHP dan script -->
                </div>
            </div>
        </div>
    </header>
</body>

</html>