<?php
include "database.php";
require "header.php";
?>

<div class="container mb-5">
    <?php
        if ($_SESSION["AccountType"] == "Restaurant") {
            echo '<div class="container">
                    <form action="./includes/createmenuitem.inc.php" method="post">
                        <div class="form-group">
                            <input type="number" class="form-control" name="UID" value="'.$_SESSION["UID"].'" hidden>
                        </div>
                        <div class="form-group">
                            <label for="FoodType">Food Type: </label>
                            <select class="form-control" name="FoodType">
                                <option selected value="Food">Food</option>
                                <option value="Dessert">Dessert</option>
                                <option value="Drink">Drink</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Name">Name: </label>
                            <input type="text" class="form-control" name="Name">
                        </div>
                        <div class="form-group">
                            <label for="Price">Price: </label>
                            <input type="number" class="form-control" name="Price" step=".01">
                        </div>
                        <div class="form-row">';
            for ($index = 1; $index < 9; $index++) {
                echo '
                <div class="form-group col-md-10">
                    <label for="Ingredient'.$index.'">Ingredient '.$index.': </label>
                    <input type="text" class="form-control" name="Ingredient'.$index.'">
                </div>
                <div class="form-group col-md-2">
                    <label for="Qty'.$index.'">Qty: </label>
                    <input type="number" class="form-control" name="Qty'.$index.'">
                </div>';
            }
            echo '</div>
                  <button type="submit" class="btn btn-primary btn-lg btn-block my-4" name="Item-submit">Create menu item</button>
                  </form>
              </div>';
        } else if ($_SESSION["AccountType"] == "Wholesaler") {
            echo '<div class="container">
                    <form action="./includes/createinventoryitem.inc.php" method="post">
                        <div class="form-group">
                            <input type="number" class="form-control" name="UID" value="'.$_SESSION["UID"].'" hidden>
                        </div>
                        <div class="form-group">
                            <label for="Name">Name: </label>
                            <input type="text" class="form-control" name="Name">
                        </div>
                        <div class="form-group">
                            <label for="Cost">Cost: </label>
                            <input type="number" class="form-control" name="Cost" step=".01">
                        </div>
                        <div class="form-group">
                            <label for="Amount">Amount: </label>
                            <input type="number" class="form-control" name="Amount">
                        </div>
                        <div class="form-group">
                            <label for="Ingredient">Ingredient: </label>
                            <input type="text" class="form-control" name="Ingredient">
                         </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block my-4" name="Item-submit">Create inventory item</button>
                    </form>
                 </div>';
        } else {
            header("Location: ../index.php");
            exit();
        }

    ?>
</div>

<?php
require "footer.php";
?>
