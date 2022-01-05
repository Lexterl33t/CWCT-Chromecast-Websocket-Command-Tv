<?php $this->layout('layout', ['title' => $this->e($title)]); ?>

<?php $this->start('body'); ?>
<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-tv"></i> Control command</h5>
            </div>
            <div class="card-body">
                    <?php if (isset($_COOKIE['configuration'])): ?>
                        <div class="mb-4">
                            <label for="ipChromecast" class="form-label">Play URL</label>
                            <input type="text" class="form-control form-control-md w-10 customForm" id="playChromecast"
                                   aria-describedby="ipHelp">
                            <div id="playHelp" class="form-text">Enter url mp4 to play in your chromecast.</div>
                        </div>
                        <div class="mb-3">
                            <label for="customRange1" class="form-label">Volume</label>
                            <input type="range" min="0" max="1" step="0.1" class="form-range volumeCustom" id="volume">
                        </div>
                        <div class="ml-3" align="center">
                            <button id="play" class="btn btn-primary customBtn"><i class="fas fa-play"></i></button>
                            <button id="stop" class="btn btn-primary customBtn"><i class="fas fa-stop"></i></button>
                            <button id="pause" class="btn btn-primary customBtn"><i class="fas fa-pause"></i></button>
                            <button id="unmute" class="btn btn-primary customBtn"><i class="fas fa-volume-up"></i></button>
                            <button id="mute" class="btn btn-primary customBtn"><i class="fas fa-volume-mute"></i></button>
                            <button id="restart" class="btn btn-primary customBtn"><i class="fas fa-reply"></i></button>
                            <button id="speed" class="btn btn-primary customBtn"><i class="fas fa-fast-forward"></i></button>
                        </div>
                    <?php else: ?>
                        <div class="mb-4">
                            <label for="ipChromecast" class="form-label">Play URL</label>
                            <input type="text" value="Locked" disabled
                                   class="form-control form-control-md w-10 customForm" id="playChromecast"
                                   aria-describedby="ipHelp">
                            <div id="playHelp" class="form-text">To unlock this functionality, save your remote
                                chromecast configuration.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="customRange1" class="form-label">Volume</label>
                            <input type="range" min="0" max="1" step="0.1" disabled class="form-range volumeCustom" id="volume">
                        </div>
                        <div class="ml-3" align="center">
                            <button id="play" disabled class="btn btn-primary customBtn"><i class="fas fa-play"></i></button>
                            <button id="stop" disabled class="btn btn-primary customBtn"><i class="fas fa-stop"></i></button>
                            <button id="pause" disabled class="btn btn-primary customBtn"><i class="fas fa-pause"></i></button>
                            <button id="unmute" class="btn btn-primary customBtn"><i class="fas fa-volume-up"></i></button>
                            <button id="mute" disabled class="btn btn-primary customBtn"><i class="fas fa-volume-mute"></i></button>
                            <button id="restart" disabled class="btn btn-primary customBtn"><i class="fas fa-reply"></i></button>
                            <button id="speed" disabled class="btn btn-primary customBtn"><i class="fas fa-fast-forward"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                    <br>
                    <div class="alert alert-danger" id="errorMessage" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="alert alert-success" id="successMessage" role="alert">
                        <i class="fas fa-check"></i>
                    </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-network-wired"></i> Remote Configuration</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/save_remote">
                    <div class="mb-4">
                        <label for="ipChromecast" class="form-label">IP Chromecast</label>
                        <input type="text" name="ip" value="<?= (isset($_COOKIE['configuration'])) ?
                            explode(':', base64_decode($_COOKIE['configuration']))[0] : "127.0.0.1"; ?>"
                               class="form-control form-control-md w-10 customForm" id="ipChromecast"
                               aria-describedby="ipHelp">
                        <div id="ipHelp" class="form-text">Here enter the ip of your chromecast.</div>
                    </div>
                    <div class="mb-3">
                        <label for="portChromecast" class="form-label">Port Chromecast</label>
                        <input type="number" name="port" value="<?= (isset($_COOKIE['configuration'])) ?
                            explode(':', base64_decode($_COOKIE['configuration']))[1] : "8009"; ?>"
                               class="form-control form-control-md customForm" id="portChromecast"
                               aria-describedby="portHelp">
                        <div id="ipHelp" class="form-text">Here enter the port of your chromecast. Default port is
                            8009.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary customButton w-100">Save</button>
                </form>
                <br>
                <?php if (!empty($container->get('flash')->getMessages())): ?>
                    <?php if (!empty($container->get('flash')->getMessages()['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <?php foreach ($container->get('flash')->getMessages()['error'] as $message): ?>
                                <?= $message; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check"></i>
                            <?php foreach ($container->get('flash')->getMessages()['success'] as $message): ?>
                                <?= $message; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function() {
        $("#errorMessage").hide();
        $("#successMessage").hide();
        $("#play").click(function(e){
            e.preventDefault();
            $.post(
                '/play_chromecast', // Un script PHP que l'on va créer juste après
                {
                    url : $("#playChromecast").val(),  // Nous récupérons la valeur de nos input que l'on fait passer à connexion.php
                    volume : $("#volume").val()
                },
                function(data){

                    var obj = JSON.parse(data);

                    if(obj['error'] != undefined) {
                        $("#successMessage").hide();
                        $("#errorMessage").html('<i class="fas fa-exclamation-triangle"></i> '+obj['error']);
                        $("#errorMessage").show();
                    } else {
                        $("#errorMessage").hide();
                        $("#successMessage").html('<i class="fas fa-check"></i> '+obj['success']);
                        $("#successMessage").show();
                    }
                },
                'text'
            );
        });
    });

    $(document).ready(function(){
        $("#errorMessage").hide();
        $("#successMessage").hide();
        $("#stop").click(function(e){
            e.preventDefault();
            $.post(
                '/stop_chromecast', // Un script PHP que l'on va créer juste après
                {
                    url : $("#playChromecast").val(),  // Nous récupérons la valeur de nos input que l'on fait passer à connexion.php
                    volume : $("#volume").val()
                },
                function(data){

                    var obj = JSON.parse(data);

                    if(obj['error'] != undefined) {
                        $("#successMessage").hide();
                        $("#errorMessage").html('<i class="fas fa-exclamation-triangle"></i> '+obj['error']);
                        $("#errorMessage").show();
                    } else {
                        $("#errorMessage").hide();
                        $("#successMessage").html('<i class="fas fa-check"></i> '+obj['success']);
                        $("#successMessage").show();
                    }
                },
                'text'
            );
        });
    });

    $(document).ready(function(){
        $("#errorMessage").hide();
        $("#successMessage").hide();
        $("#restart").click(function(e){
            e.preventDefault();
            $.post(
                '/restart_chromecast', // Un script PHP que l'on va créer juste après
                {
                    url : $("#playChromecast").val(),  // Nous récupérons la valeur de nos input que l'on fait passer à connexion.php
                    volume : $("#volume").val()
                },
                function(data){

                    var obj = JSON.parse(data);

                    if(obj['error'] != undefined) {
                        $("#successMessage").hide();
                        $("#errorMessage").html('<i class="fas fa-exclamation-triangle"></i> '+obj['error']);
                        $("#errorMessage").show();
                    } else {
                        $("#errorMessage").hide();
                        $("#successMessage").html('<i class="fas fa-check"></i> '+obj['success']);
                        $("#successMessage").show();
                    }
                },
                'text'
            );
        });
    });

    $(document).ready(function(){
        $("#errorMessage").hide();
        $("#successMessage").hide();
        $("#pause").click(function(e){
            e.preventDefault();
            $.post(
                '/pause_chromecast', // Un script PHP que l'on va créer juste après
                {
                    url : $("#playChromecast").val(),  // Nous récupérons la valeur de nos input que l'on fait passer à connexion.php
                    volume : $("#volume").val()
                },
                function(data){

                    var obj = JSON.parse(data);

                    if(obj['error'] != undefined) {
                        $("#successMessage").hide();
                        $("#errorMessage").html('<i class="fas fa-exclamation-triangle"></i> '+obj['error']);
                        $("#errorMessage").show();
                    } else {
                        $("#errorMessage").hide();
                        $("#successMessage").html('<i class="fas fa-check"></i> '+obj['success']);
                        $("#successMessage").show();
                    }
                },
                'text'
            );
        });
    });

    $(document).ready(function(){
        $("#errorMessage").hide();
        $("#successMessage").hide();
        $("#mute").click(function(e){
            e.preventDefault();
            $.post(
                '/mute_chromecast', // Un script PHP que l'on va créer juste après
                {
                    url : $("#playChromecast").val(),  // Nous récupérons la valeur de nos input que l'on fait passer à connexion.php
                    volume : $("#volume").val()
                },
                function(data){

                    var obj = JSON.parse(data);

                    if(obj['error'] != undefined) {
                        $("#successMessage").hide();
                        $("#errorMessage").html('<i class="fas fa-exclamation-triangle"></i> '+obj['error']);
                        $("#errorMessage").show();
                    } else {
                        $("#errorMessage").hide();
                        $("#successMessage").html('<i class="fas fa-check"></i> '+obj['success']);
                        $("#successMessage").show();
                    }
                },
                'text'
            );
        });
    });

    $(document).ready(function(){
        $("#errorMessage").hide();
        $("#successMessage").hide();
        $("#unmute").click(function(e){
            e.preventDefault();
            $.post(
                '/unmute_chromecast', // Un script PHP que l'on va créer juste après
                {
                    url : $("#playChromecast").val(),  // Nous récupérons la valeur de nos input que l'on fait passer à connexion.php
                    volume : $("#volume").val()
                },
                function(data){

                    var obj = JSON.parse(data);

                    if(obj['error'] != undefined) {
                        $("#successMessage").hide();
                        $("#errorMessage").html('<i class="fas fa-exclamation-triangle"></i> '+obj['error']);
                        $("#errorMessage").show();
                    } else {
                        $("#errorMessage").hide();
                        $("#successMessage").html('<i class="fas fa-check"></i> '+obj['success']);
                        $("#successMessage").show();
                    }
                },
                'text'
            );
        });
    });

    $(document).ready(function(){
        $("#errorMessage").hide();
        $("#successMessage").hide();
        $('#volume').on('input', function () {
            $.post(
                '/set_volume', // Un script PHP que l'on va créer juste après
                {
                    volume : $("#volume").val()
                },
                function(data){


                },
                'text'
            );
        });
    });
</script>
<?php $this->stop(); ?>
