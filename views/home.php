<?php $this->layout('layout', ['title' => $this->e($title)]); ?>

<?php $this->start('body'); ?>
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-tv"></i> Control command</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-4">
                            <label for="ipChromecast" class="form-label">Play URL</label>
                            <input type="text" class="form-control form-control-md w-10 customForm" id="playChromecast" aria-describedby="ipHelp">
                            <div id="playHelp" class="form-text">Enter url mp4 to play in your chromecast.</div>
                        </div>
                        <div class="mb-3">
                            <label for="customRange1" class="form-label">Volume</label>
                            <input type="range" class="form-range volumeCustom" id="customRange1">
                        </div>
                        <div class="ml-3" align="center">
                            <button class="btn btn-primary customBtn"><i class="fas fa-play"></i></button>
                            <button class="btn btn-primary customBtn"><i class="fas fa-stop"></i></button>
                            <button class="btn btn-primary customBtn"><i class="fas fa-pause"></i></button>
                            <button class="btn btn-primary customBtn"><i class="fas fa-volume-mute"></i></button>
                            <button class="btn btn-primary customBtn"><i class="fas fa-reply"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-network-wired"></i> Remote Configuration</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-4">
                            <label for="ipChromecast" class="form-label">IP Chromecast</label>
                            <input type="text" class="form-control form-control-md w-10 customForm" id="ipChromecast" aria-describedby="ipHelp">
                            <div id="ipHelp" class="form-text">Here enter the ip of your chromecast.</div>
                        </div>
                        <div class="mb-3">
                            <label for="portChromecast" class="form-label">Port Chromecast</label>
                            <input type="number" class="form-control form-control-md customForm" id="portChromecast" aria-describedby="portHelp">
                            <div id="ipHelp" class="form-text">Here enter the port of your chromecast. Default port is 8009.</div>
                        </div>
                        <button type="submit" class="btn btn-primary customButton w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $this->stop(); ?>
