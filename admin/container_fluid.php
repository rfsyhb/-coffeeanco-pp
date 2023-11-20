<div class="row g-3 my-2">
    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <?php
                $query = mysqli_query($connect, "SELECT prod_id FROM produk ORDER BY prod_id");
                $row = mysqli_num_rows($query);
                echo '<h3 class="fs-2">' . $row . '</h3>';
                ?>
                <p class="fs-5">Products</p>
            </div>
            <i class="fas fa-gift fs-1 primary-text border rounded-full secondary-bg p-3"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <?php
                $query = mysqli_query($connect, "SELECT order_id FROM orders ORDER BY order_id");
                $row = mysqli_num_rows($query);
                echo '<h3 class="fs-2">' . $row . '</h3>';
                ?>
                <p class="fs-5">Orders</p>
            </div>
            <i class="fas fa-shopping-cart fs-1 primary-text border rounded-full secondary-bg p-3"></i>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <?php
                $query = mysqli_query($connect, "SELECT order_item_id FROM order_details ORDER BY order_item_id");
                $row = mysqli_num_rows($query);
                echo '<h3 class="fs-2">' . $row . '</h3>';
                ?>
                <p class="fs-5">Order Details</p>
            </div>
            <i class="fas fa-book fs-1 primary-text border rounded-full secondary-bg p-3"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <?php
                $query = mysqli_query($connect, "SELECT cust_id FROM pengunjung ORDER BY cust_id");
                $row = mysqli_num_rows($query);
                echo '<h3 class="fs-2">' . $row . '</h3>';
                ?>
                <p class="fs-5">Customer</p>
            </div>
            <i class="fas fa-users fs-1 primary-text border rounded-full secondary-bg p-3"></i>
        </div>
    </div>
</div>