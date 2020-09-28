<form class="form-inline mb-4" action="./autorestock.php" method="get">
    <div class="input-group-prepend pr-3">
        <div class="input-group-text">Sort by threshold</div>
    </div>
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-info <?php echo ($_GET['psort'] ?? 0) == 1 ? "active" : ""; ?>">
            <input type="radio" id="Ascending" name="psort" class="form-check-input" value="1" autocomplete="off" <?php echo ($_GET['psort'] ?? 0) == 1 ? "checked" : ""; ?>>
            Ascending <i class="fas fa-sort-numeric-down pl-2"></i>
        </label>
        <label class="btn btn-info <?php echo ($_GET['psort'] ?? 0) == 2 ? "active" : ""; ?>">
            <input type="radio" id="Ascending" name="psort" class="form-check-input" value="2" autocomplete="off" <?php echo ($_GET['psort'] ?? 0) == 2 ? "checked" : ""; ?>>
            Descending <i class="fas fa-sort-numeric-up pl-2"></i>
        </label>
    </div>
    <div class="input-group px-3">
        <div class="input-group-prepend">
            <div class="input-group-text">Min</div>
        </div>
        <input type="number" class="form-control" id="Min" name="Min" step=".01" value="<?php echo $_GET["Min"] ?? "" ?>">
    </div>
    <div class="input-group pr-3">
        <div class="input-group-prepend">
            <div class="input-group-text">Max</div>
        </div>
        <input type="number" class="form-control" id="Max" name="Max" step=".01" value="<?php echo $_GET["Max"] ?? "" ?>">
    </div>
    <button type="submit" class="btn btn-success">Sort</button>
</form>
<a class="btn btn-outline-success mb-4 btn-block" href="./autorestock.php">Show All</a>
<a class="btn btn-success mb-4 btn-block" data-toggle="modal" href="#autoRestockModal">Add Rule</a>

<?php
    $sql = "SELECT autorestock.*, ingredient.Name, COALESCE(restaurantstorage.Amount, 0) as CurrentStock, inventoryitem.Name as WholesalerItem, inventoryitem.Amount as WholesalerAmount, wholesaler.Name as WholesalerName FROM `autorestock` 
        INNER JOIN ingredient ON ingredient.INID = autorestock.INID 
        LEFT JOIN restaurantstorage ON restaurantstorage.UID = autorestock.UID AND restaurantstorage.INID = autorestock.INID 
        INNER JOIN inventoryitem ON inventoryitem.UID = autorestock.WholesalerUID AND inventoryitem.IID = autorestock.IID AND inventoryitem.INID = autorestock.INID
        INNER JOIN wholesaler ON wholesaler.UID = autorestock.WholesalerUID
        WHERE autorestock.UID = '" . $_SESSION['UID'] . "'";

    if (isset($_GET["Min"])) {
        if (is_numeric($_GET["Min"])) {
            $sql .= " AND Threshold >= " . $_GET["Min"];
        }
    }
    if (isset($_GET["Max"])) {
        if (is_numeric($_GET["Max"])) {
            $sql .= " AND Threshold <= " . $_GET["Max"];
        }
    }
    if (isset($_GET["psort"])) {
        if ($_GET["psort"] == 1) {
            $sql .= " ORDER BY Threshold ASC";
        }
        if ($_GET["psort"] == 2) {
            $sql .= " ORDER BY Threshold DESC";
        }
    }

    $res = $mysqli->query($sql);

    // TODO NOTE
    // Change "More Info" buttons to "Edit"

    if (!$res) {
        header("Location: ./restaurant.php?error=sqlerror1");
        exit();
    } else {
        $first = false;
        $counter = 0;
        while ($row = $res->fetch_object()) {
            if (!$first) {
                $first = true;
                $counter += 1;
                echo "<div class='row mb-4'>";
            } else if ($counter === 3) {
                echo "</div><div class='row mb-4'>";
                $counter = 1;
            } else {
                $counter += 1;
            }
            echo "<div class='col-sm-4'>
                    <div class='card text-center'>
                        <div class='card-header'>$row->Name</div>
                        <div class ='card-body'>
                            <h5 class='card-title'>Threshold: $row->Threshold</h5>
                            <p class='card-text'>To order: $row->Amount of $row->WholesalerItem (lots of $row->WholesalerAmount) from $row->WholesalerName</p>
                            <p class='card-text'>Current: $row->CurrentStock</p>
                            <a data-auid='$row->AUID' data-wholesaleruid='$row->WholesalerUID' data-iid='$row->IID' data-inid='$row->INID' data-amount='$row->Amount' data-threshold='$row->Threshold' data-toggle='modal' href='#autoRestockModal' class='btn btn-primary'>Edit Rule</a>
                            <a data-auid='$row->AUID' onclick='deleteRule($(this))' href='' class='btn btn-danger'>Delete Rule</a>
                        </div>
                    </div>
                </div>";
        }
        echo '</div>';
    }

?>


<div class="modal fade" id="autoRestockModal" tabindex="-1" role="dialog" aria-labelledby="autoRestockModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="autoRestockModalLabel">Edit Rule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="error-text" id="autoRestockError"></p>
                <form action="">
                    <div class="form-group">
                        <label for="item">Select Item</label>
                        <select class="form-control" name="item" id="autoRestockItem" required>
                            <option selected value="-1">Select an item</option>
                            <?php
                                $res = $mysqli->query("SELECT inventoryitem.*, wholesaler.Name as wholesaler FROM inventoryitem 
                                    LEFT JOIN wholesaler ON inventoryitem.UID = wholesaler.UID");
                                    // WHERE NOT EXISTS (SELECT 1 FROM autorestock a WHERE a.WholesalerUID = inventoryitem.UID AND a.IID = inventoryitem.IID AND a.INID = inventoryitem.INID)");
                                while ($row = $res->fetch_object()) {
                                    echo "<option value='$row->UID-$row->IID-$row->INID'>$row->Name ($row->Cost per $row->Amount) @ $row->wholesaler</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="threshold">Enter Threshold</label>
                        <input type="number" class="form-control" name="threshold" id="autoRestockThreshold" required>
                    </div>
                    <div class="form-group">
                        <label for="threshold">Enter Order Amount</label>
                        <input type="number" class="form-control" name="amount" id="autoRestockAmount" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="autoRestockSubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#autoRestockModal").on('show.bs.modal', function(e) {
        $("#autoRestockError").text("");
        let btn = $(e.relatedTarget);
        if (btn.data('iid') === undefined) {
            $("#autoRestockModalLabel").text("Add Rule");
            $("#autoRestockItem").val("-1").prop("disabled", false);
            $("#autoRestockThreshold").val("");
            $("#autoRestockAmount").val("");
        } else {
            $("#autoRestockModalLabel").text("Edit Rule");
            $("#autoRestockItem").val(btn.data("wholesaleruid") + "-" + btn.data("iid") + "-" + btn.data("inid")).prop("disabled", true);
            $("#autoRestockThreshold").val(btn.data("threshold"));
            $("#autoRestockAmount").val(btn.data("amount"));
        }
        $("#autoRestockSubmit").data(btn.data());
    });

    $("#autoRestockSubmit").on("click", function () {
        let data = $("#autoRestockSubmit").data();
        if (data.uid === undefined) {
            var item = $("#autoRestockItem").val().split("-");
            data.wholesaleruid = item[0];
            data.iid = item[1];
            data.inid = item[2];
        }
        $.ajax({
            url: "/api/autorestocksave.php",
            method: "post",
            data: {
                auid: data.auid,
                wholesaleruid: data.wholesaleruid,
                iid: data.iid,
                inid: data.inid,
                threshold: $("#autoRestockThreshold").val(),
                amount: $("#autoRestockAmount").val()
            },
            success: function() {
                $("#autoRestockModal").modal("hide");
                window.location.reload();
            },
            error: function(res) {
                $("#autoRestockError").text(res.responseJSON.errorMessage);
            }
        })
    });

    function deleteRule(btn) {
        $.ajax({
            url: "/api/autorestockdelete.php",
            method: "post",
            data: btn.data(),
            success: function() {
                window.location.reload();
            },
            error: function(res) {
                console.log(res);
            }
        })
    }
</script>
