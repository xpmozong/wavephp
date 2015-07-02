<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Debug messages</h3>
        </div>
        <div class="panel-body" style="word-break: break-all; word-wrap:break-word;">
            <?php 
                echo '<p>Session:</p>';
                print_r($debug['session']);
                echo '<br><br><p>Loaded Class:</p>';
                foreach ($debug['files'] as $key => $value) {
                    echo '<p>'.$value.'</p>';
                }
                echo "<br><p>Database:</p>";
                foreach ($debug['database'] as $key => $value) {
                    echo '<p>[ Log time: '.$value['log_time'].' ]';
                    echo '[ Expend time: '.$value['expend_time'].' ]';
                    echo $value['message']."</p>";
                }
                echo '<br><p>Escape time: '.(microtime(TRUE) - START_TIME).', ';
                echo count($debug['database']).' queries, ';
                echo 'PHP Memory usage: '.
                    ((memory_get_usage() - MEMORY_USAGE_START) / 1024).' KB, ';
                echo 'Server time: '.date('Y-m-d H:i:s').'</p>';
            ?>
        </div>
    </div>
</div>