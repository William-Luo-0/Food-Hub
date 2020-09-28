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
    <div class="input-group px-2">
        <div class="input-group-prepend">
            <div class="input-group-text">Min $</div>
        </div>
        <input type="number" class="form-control" id="Min" name="Min" step=".01" value="">
    </div>
    <div class="input-group pr-3">
        <div class="input-group-prepend">
            <div class="input-group-text">Max $</div>
        </div>
        <input type="number" class="form-control" id="Max" name="Max" step=".01" value="">
    </div>
</form>
<a class="btn btn-outline-success mb-4 btn-block" href="./customerloyalty.php">Show All</a>

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
        let min = $("input[name=Min]").val();
        let max = $("input[name=Max]").val();

        $.ajax({
            url: "/api/getcustomerloyalty.php",
            method: "post",
            data: {
                type: type,
                min: min,
                max: max
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
                        "                        <div class='card-header'>" + data[row].Name + "</div>\n" +
                        "                    <div class ='card-body'>\n" +
                        "                        <p class='card-text'>" + data[row].EmailAddress + "</p>\n" +
                        "                        <p class='card-text'>" + data[row].PhoneNumber + "</p>\n" +
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
