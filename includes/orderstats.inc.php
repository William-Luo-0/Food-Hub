<form class="form-inline mb-4">
    <div class="input-group-prepend pr-2">
        <div class="input-group-text">Specify items:</div>
    </div>
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-info">
            <input type="radio" name="tsort" class="form-check-input" value="0" autocomplete="off">
            Food <i class="fas fa-hamburger pl-2"></i>
        </label>
        <label class="btn btn-info">
            <input type="radio" name="tsort" class="form-check-input" value="1" autocomplete="off">
            Dessert <i class="fas fa-ice-cream pl-2"></i>
        </label>
        <label class="btn btn-info">
            <input type="radio" name="tsort" class="form-check-input" value="2" autocomplete="off">
            Drink <i class="fas fa-wine-glass pl-2"></i>
        </label>
        <label class="btn btn-info active">
            <input type="radio" name="tsort" class="form-check-input" value="3" autocomplete="off" checked>
            Everything <i class="fas fa-utensils pl-2"></i>
        </label>
    </div>
    <div class="input-group-prepend pl-5 pr-2">
        <div class="input-group-text">Group by:</div>
    </div>
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-info active">
            <input type="radio" name="grouping" class="form-check-input" value="0" autocomplete="off" checked>
            Customer Name <i class="fas fa-user pl-2"></i>
        </label>
        <label class="btn btn-info">
            <input type="radio" name="grouping" class="form-check-input" value="1" autocomplete="off">
            Food Name <i class="fas fa-clipboard-list pl-2"></i>
        </label>
        <label class="btn btn-info">
            <input type="radio" name="grouping" class="form-check-input" value="2" autocomplete="off">
            Food Type <i class="fas fa-utensils pl-2"></i>
        </label>
    </div>
</form>
<a class="btn btn-outline-success mb-4 btn-block" href="./orderstats.php">Show All</a>

<div id="results">

</div>

<script type="text/javascript">
    $("input").on('keyup change', function(e) {
        refreshItems();
    });

    $(function() {
        refreshItems();
    });

    function refreshItems() {
        let type = $("input[name=tsort]:checked").val();
        let grouping = $("input[name=grouping]:checked").val();

        $.ajax({
            url: "/api/getorderstats.php",
            method: "post",
            data: {
                type: type,
                grouping: grouping
            },
            success: function(data) {
                let first = false;
                let counter = 0;
                let html = "";
                $.each(data, function(row) {
                    if (!first) {
                        first = true;
                        counter++;
                        html += "<div class='row mb-4'>";
                    } else if (counter === 3) {
                        counter = 1;
                        html += "</div><div class='row mb-4'>";
                    } else {
                        counter++;
                    }
                    html += "<div class='col-sm-4'>\n" +
                        "                    <div class='card text-center'>\n" +
                        "                        <div class='card-header'>" + data[row].headerText + "</div>\n" +
                        "                    <div class ='card-body'>\n" +
                        "                        <p class='card-text'>Items ordered: " + data[row].numItems + "</p>\n" +
                        "                        <p class='card-text'>Total value: " + data[row].totalValue + "</p>\n" +
                        "                    </div>\n" +
                        "                    </div>\n" +
                        "                    </div>";
                });
                $("#results").html(html == "" ? "<p class='error-text'>No results found for these settings.</p>" : html);
            },
            error: function() {
                $("#results").html("<p class='error-text'>There was an error getting the results</p>");
            }
        });
    }
</script>
