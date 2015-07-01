<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Debug messages</h3>
        </div>
        <div class="panel-body">
            <?php 
                echo '<pre style="background-color:#FFF;">Session:<br>'; 
                print_r($session);
                echo '<br>Loaded Class:<br>';
                print_r($files);
            ?>
        </div>
    </div>
</div>