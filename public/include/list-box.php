<?php 
function listBox($background,$pesan,$jumlah,$icon){
    echo "<div class=\"col-lg-3 col-xs-6\">
    <!-- small box -->
    <div class=\"small-box bg-$background\">
        <div class=\"inner\">
            <h3>$jumlah</h3>

            <p>$pesan</p>
        </div>
        <div class=\"icon\">
            <i class=\"fa fa-$icon\"></i>
        </div>
        <a href=\"#\" class=\"small-box-footer\">More info <i class=\"fa fa-arrow-circle-right\"></i></a>
    </div>
</div>";
} 
?>