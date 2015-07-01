<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Debug messages</h3>
        </div>
        <div class="panel-body">
            <?php 
                echo '<pre style="background-color:#FFF;"><p>Session:<br>'; 
                print_r($session);
                echo '<br>Loaded Class:<br>';
                print_r($files);
            ?>
        </div>
    </div>
</div>